<?php

use Gabia\LaravelDto\DtoService;
use Hiworks\AdminAuditLog\Builder\AdminAuditLogBuilderV1;
use Hiworks\AdminAuditLog\Producer\AdminAuditLogKafkaProducer;
use Hiworks\AdminAuditLog\AdminAuditLog;
use Hiworks\AdminAuditLog\Enums\MenuCodeType;
use Hiworks\AdminAuditLog\Enums\LevelType;
use Hiworks\KafkaProducer\Producer;
use Hiworks\KafkaProducer\ProducerConfig;
use Monolog\Logger;

class test extends \PHPUnit\Framework\TestCase
{
    private $dtoService;

    /**
     * Kafka Producer Setup
     * @throws Exception
     */
    function setup()
    {
        $this->dtoService = new DtoService();
    }

    /**
     * Validation Wrong Builder
     * The Exception Message will tell to choose write version of builder
     * @test
     */
    function check_builder()
    {
        try {
            $admin_audit_log = AdminAuditLog::builder('v2')
                ->build();
        }catch(Exception $e){
            $this->assertEquals('AdminAuditLog Exception Occurred : Please Select Correct Version of Builder',
                $e->getMessage());
        }
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
            $admin_audit_log = AdminAuditLog::builder('v1')
                ->setMenu(MenuCodeType::APPROVAL)
                ->setLevel(1)
                ->setAccessIp('127.0.0.1')
                ->setOfficeNum(123)
                ->setUserId('test_user')
                ->setUserNum("")
                ->setEngFullMessage('This is Full Eng Message')
                ->setEngMessage('This is Short Eng Message')
                ->setShortMessage('This is Short Kor Message')
                ->setFullMessage('This is Full Kor Message')
                ->build();
        }catch(Exception $e){
            $this->assertEquals('AdminAuditLog Exception Occurred : [Not Valid Level] [user_name is not set] [user_num is not set]',
            $e->getMessage());
        }
    }

    /**
     * Builder Result Test
     * Testing AdminAuditLogV1 returns json_string using DTOservice
     * @test
     */
     function check_and_var_dump_Builder()
     {
         try {
             $admin_audit_log = AdminAuditLog::builder('v1')
                 ->setMenu(MenuCodeType::APPROVAL)
                 ->setLevel(LevelType::A)
                 ->setAccessIp('127.0.0.1')
                 ->setUserName('김**')
                 ->setOfficeNum(123)
                 ->setUserId('test_user')
                 ->setUserNum(123)
                 ->setEngFullMessage('This is Full Eng Message')
                 ->setEngMessage('This is Short Eng Message')
                 ->setShortMessage('This is Short Kor Message')
                 ->setFullMessage('This is Full Kor Message')
                 ->build();
             var_dump($admin_audit_log);
         }
         catch (Exception $e){

         }
     }

    /**
     * Test Kafka Sending
     * @test
     * @throws Exception
     */
    function sendKafkaMessage()
    {
        $logger = new Logger('my_logger');
        try {
            $admin_audit_log = AdminAuditLog::builder('v1')
                ->setMenu(MenuCodeType::APPROVAL)
                ->setLevel(LevelType::A)
                ->setAccessIp('127.0.0.1')
                ->setUserName('김**')
                ->setOfficeNum(123)
                ->setUserId('test_user')
                ->setUserNum(123)
                ->setEngFullMessage('This is Full Eng Message')
                ->setEngMessage('This is Short Eng Message')
                ->setShortMessage('This is Short Kor Message')
                ->setFullMessage('This is Full Kor Message')
                ->build();
            $adminAuditLogKafkaProducer = new AdminAuditLogKafkaProducer();
            //$adminAuditLogKafkaProducer->setLogger($logger);
            $adminAuditLogKafkaProducer->setBootstrapServer("kafka01:9092,kafka02:9092,kafka03:9092");
            $adminAuditLogKafkaProducer->sendMessage('tracking.admin.audit',$admin_audit_log);
        }catch(Exception $e){
            var_dump($e->getMessage());
        }
    }


    /**
     * Not Working Well...
     * @test
     */
    function getKafkaMessages()
    {
        $logger = new Logger('my_logger');
        $config = \Kafka\ConsumerConfig::getInstance();
        $config->setMetadataRefreshIntervalMs(10000);
        $config->setMetadataBrokerList('kafka01:9092,kafka02:9092,kafka03:9092');
        $config->setGroupId('test');
        $config->setBrokerVersion('0.10.1.0');
        $config->setTopics(['tracking.admin.audit']);
        //$config->setOffsetReset('latest');
        $config->setOffsetReset('earliest');

        $kafka_consumer = new \Kafka\Consumer();
        //Debugging
        $kafka_consumer->setLogger($logger);
        $kafka_consumer->start(function($topic, $part, $message) {
            var_dump($topic);
            var_dump($message);
        });
    }

}