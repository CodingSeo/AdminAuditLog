<?php
use \Mockery as m;
use Gabia\LaravelDto\DtoService;

use Hiworks\AdminAuditLogBuilder\Builder\AdminAuditLogBuilder;
use Hiworks\AdminAuditLogBuilder\Config\AdminAuditLogConfig_V1;
use Hiworks\AdminAuditLogBuilder\Enums\MenuCodeType;
use Hiworks\AdminAuditLogBuilder\Enums\LevelType;
use Hiworks\KafkaProducer\Producer;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

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
        //DTO service to print string json data from Builder

        $this->dtoService = new DtoService();
        //y
        $producerConfig = new \Hiworks\KafkaProducer\ProducerConfig();
        $producerConfig->setBootstrapServer("kafka01:9092,kafka02:9092,kafka03:9092");
        $producerConfig->setRequireAck(1);
        $this->kafka_producer = new Producer($producerConfig);
        $logger = new \Monolog\Logger('my_logger');
        $this->kafka_producer->setLogger($logger);
        $this->assertNotNull($this->kafka_producer);
    }

    /**
     * Validation Testing
     * The Exception Message will tell you what's the missing parts
     * IP should be IP4 format and office_num and user_num should be numeric
     * @test
     */
    function check_validation()
    {
        try {
            date_default_timezone_set('PRC');
            $admin_audit_builder = new AdminAuditLogBuilder();
            $admin_audit_dto = $admin_audit_builder->setConfig(new AdminAuditLogConfig_V1())
                ->setMenu(MenuCodeType::APPROVAL)
                ->setAccessIp('1.12.1111')
                ->setUserName('test')
                ->setOfficeNum(123)
                ->setUserId('tets')
                ->setUserNum(123)
                ->setFullMessage('t')
                ->setLevel(1)
                ->build();
            $this->assertFalse($admin_audit_dto);
        }catch(Exception $e){
            $this->assertEquals("AdminAuditLog Exception Occurred : [Not Valid Level] [short_korean is not set] [eng_message is not set] [full_eng_message is not set] [_access_ip is IPv4 format]",
            $e->getMessage());
        }
    }

    /**
     * Builder Result Test
     * Testing AdminAuditLogBuilder returns json_string using DTOservice
     * @test
     */
     function check_and_var_dump_Builder_JsonData()
     {
         try {
             date_default_timezone_set('UTC');
             $admin_audit_builder = new AdminAuditLogBuilder();
             $admin_audit_dto = $admin_audit_builder->setConfig(new AdminAuditLogConfig_V1())
                 ->setMenu(MenuCodeType::APPROVAL)
                 ->setLevel(LevelType::A)
                 ->setAccessIp('127.0.0.1')
                 ->setUserName('김**')
                 ->setOfficeNum(123)
                 ->setUserId('tets')
                 ->setUserNum(123)
                 ->setEngFullMessage('This is Full Eng Message')
                 ->setEngShortMessage('This is Short Eng Message')
                 ->setShortMessage('This is Short Kor Message')
                 ->setFullMessage('This is Full Kor Message')
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

    /**
     * @test
     */
    function sendKafkaMessages()
    {
        try {
            date_default_timezone_set('UTC');
            $admin_audit_builder = new AdminAuditLogBuilder();
            $admin_audit_dto = $admin_audit_builder->setConfig(new AdminAuditLogConfig_V1())
                ->setMenu(MenuCodeType::APPROVAL)
                ->setLevel(LevelType::A)
                ->setAccessIp('127.0.0.1')
                ->setUserName('김**')
                ->setOfficeNum(123)
                ->setUserId('tets')
                ->setUserNum(123)
                ->setEngFullMessage('This is Full Eng Message')
                ->setEngShortMessage('This is Short Eng Message')
                ->setShortMessage('This is Short Kor Message')
                ->setFullMessage('This is Full Kor Message')
                ->build();
            $result = $this->kafka_producer->send("tracking.admin.audit", $admin_audit_dto);
            $this->assertNotNull($result);
        }catch(Exception $e){
            var_dump($e->getMessage());
        }
    }

//    /**
//     * @test
//     */
    function getKafkaMessages()
     {
         date_default_timezone_set('UTC');
         $logger = new Logger('my_logger');
         $logger->pushHandler(new StreamHandler('php://stdout'));
         $config = \Kafka\ConsumerConfig::getInstance();
         $config->setMetadataRefreshIntervalMs(10000);
         $config->setMetadataBrokerList('kafka01:9092,kafka02:9092,kafka03:9092');
         $config->setGroupId('test');
         $config->setBrokerVersion('0.10.1.0');
         $config->setTopics(['tracking.account.audit']);
         $config->setOffsetReset('latest');
         $kafka_consumer = new \Kafka\Consumer();
         $kafka_consumer->setLogger($logger);
         $kafka_consumer->start(function($topic, $part, $message) {
            var_dump($topic);
            var_dump($message);
         });
     }
}