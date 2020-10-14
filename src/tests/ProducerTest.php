<?php
use \Mockery as m;
use Gabia\LaravelDto\DtoService;

use Hiworks\AdminAuditLogBuilder\Builder\AdminAuditLogBuilder;
use Hiworks\AdminAuditLogBuilder\Config\AdminAuditLogConfig_V1;
use Hiworks\AdminAuditLogBuilder\Enums\MenuCodeType;
use Hiworks\AdminAuditLogBuilder\Enums\LevelType;
use Hiworks\KafkaProducer\Producer;

class ProducerTest extends \PHPUnit\Framework\TestCase
{
    private $kafka_producer;
    private $dtoService;

    /**
     * Kafka Producer Setup
     * @throws Exception
     */
    function setup()
    {
        $this->dtoService = new DtoService();
        $producerConfig = new \Hiworks\KafkaProducer\ProducerConfig();
        $producerConfig->setBootstrapServer("kafka01:9092,kafka02:9092,kafka03:9092");
        $producerConfig->setRequireAck(1);
        $this->kafka_producer = new Producer($producerConfig);
        $logger = new \Monolog\Logger('my_logger');
        $this->kafka_producer->setLogger($logger);
        $this->assertNotNull($this->kafka_producer);
    }
    /**
     * @test
     */
    function check_validation()
    {
        try {
            date_default_timezone_set('PRC');
            $admin_audit_builder = new AdminAuditLogBuilder();
            $admin_audit_dto = $admin_audit_builder->setConfig(new AdminAuditLogConfig_V1())
                ->loadAdminAuditLogDTO()
                ->setMenu(MenuCodeType::APPROVAL)
                ->setAccessIp('1.12.11.11')
                ->setUserName('test')
                ->setOffice(123)
                ->setUserId('tets')
                ->setUserNumber(123)
                ->setFullMessage('t')
                ->setLevel(1)
                ->build();
            $this->assertFalse($admin_audit_dto);
        }catch(Exception $e){
            $this->assertEquals("AdminAuditLog Exception Occurred : [Not Valid Level] [short_korean is not set] [eng_message is not set] [full_eng_message is not set]",$e->getMessage());
        }
    }

    /** @test */
     function check_adn_var_dump_BuilderJsonData()
     {
         try {
             date_default_timezone_set('PRC');
             $admin_audit_builder = new Hiworks\AdminAuditLogBuilder\Builder\AdminAuditLogBuilder();
             $admin_audit_dto = $admin_audit_builder->setConfig(new AdminAuditLogConfig_V1())
                 ->loadAdminAuditLogDTO()
                 ->setMenu(MenuCodeType::APPROVAL)
                 ->setLevel(LevelType::A)
                 ->setAccessIp('1.1.1.1')
                 ->setUserName('test')
                 ->setOffice(123)
                 ->setUserId('tets')
                 ->setUserNumber(123)
                 ->setEngFullMessage('t')
                 ->setEngMessage('t')
                 ->setShortMessage('t')
                 ->setFullMessage('t')
                 ->build();
                 $valueArr = $this->dtoService->toArray($admin_audit_dto);
                 $valueArr = json_encode($valueArr);
                 var_dump($valueArr);
         }
         catch (Exception $e){
             $this->assertEquals("",
             $e->getMessage());
         }
     }

     /** @test */
    function sendKafkaMessages()
    {
        try {
            date_default_timezone_set('PRC');
            $admin_audit_builder = new Hiworks\AdminAuditLogBuilder\Builder\AdminAuditLogBuilder();
            $admin_audit_dto = $admin_audit_builder->setConfig(new AdminAuditLogConfig_V1())
                ->loadAdminAuditLogDTO()
                ->setMenu(MenuCodeType::APPROVAL)
                ->setAccessIp('1.1.1.1')
                ->setUserName('test')
                ->setOffice(123)
                ->setUserId('tets')
                ->setUserNumber(123)
                ->setEngFullMessage('t')
                ->setEngMessage('t')
                ->setShortMessage('t')
                ->setFullMessage('t')
                ->setLevel(LevelType::A)
                ->build();
            for ($i = 0; $i < 2; $i++) {
                $result = $this->kafka_producer->send("tracking.admin.audit", $admin_audit_dto);
                var_dump($result);
                $this->assertNotNull($result);
            }
        }catch(Exception $e){
            var_dump($e->getMessage());
        }
    }

    /** @test */
     function getKafkaMessages()
     {
         date_default_timezone_set('PRC');
         $logger = new \Monolog\Logger('my_logger');
         $config = \Kafka\ConsumerConfig::getInstance();
         $config->setMetadataRefreshIntervalMs(10000);
         $config->setMetadataBrokerList('kafka01:9092,kafka02:9092,kafka03:9092');
//         $config->setGroupId('test');
         $config->setBrokerVersion('0.10.1.0');
         $config->setTopics(['tracking.account.audit']);
         $config->setOffsetReset('earliest');
         $kafka_consumer = new \Kafka\Consumer();
         $kafka_consumer->setLogger($logger);
         $kafka_consumer->start(function($topic, $part, $message) {
            var_dump($topic);
             var_dump($part);
            var_dump($message);
         });
     }

}