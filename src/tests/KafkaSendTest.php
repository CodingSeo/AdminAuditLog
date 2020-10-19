<?php

use Hiworks\AdminAuditLogBuilder\Builder\AdminAuditLogBuilder;
use Hiworks\AdminAuditLogBuilder\Config\AdminAuditLogConfig_V1;
use Hiworks\AdminAuditLogBuilder\Enums\MenuCodeType;
use Hiworks\AdminAuditLogBuilder\Enums\LevelType;
use Hiworks\KafkaProducer\Producer;

class KafkaSendTest extends \PHPUnit\Framework\TestCase
{
    /**
     * Using Kafka producer send admin_audit_dto
     * @test
     */
    function sendKafkaMessages()
    {
        $producerConfig = new \Hiworks\KafkaProducer\ProducerConfig();
        $producerConfig->setBootstrapServer("kafka01:9092,kafka02:9092,kafka03:9092");
        $producerConfig->setRequireAck(1);
        $kafka_producer = new Producer($producerConfig);
        //Debugging Logger
        $logger = new \Monolog\Logger('my_logger');
        $kafka_producer->setLogger($logger);
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
            $result = $kafka_producer->send("tracking.admin.audit", $admin_audit_dto);
            $this->assertNotNull($result);
        }catch(Exception $e){
            var_dump($e->getMessage());
        }
    }
}