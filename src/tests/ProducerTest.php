<?php

use Hiworks\AdminAuditLog\Producer\AdminAuditLogKafkaProducer;
use Hiworks\AdminAuditLog\AdminAuditLog;
use Hiworks\AdminAuditLog\Enums\MenuCodeType;
use Hiworks\AdminAuditLog\Enums\LevelType;
use Monolog\Logger;

class ProducerTest extends \PHPUnit\Framework\TestCase
{

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
            $this->assertEquals("Hiworks\AdminAuditLog\Exceptions\AdminAuditLogException :  Please Select Correct Version of Builder",
                get_class($e) . " : " . $e->getMessage());
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
                ->setUserNum("fdffd")
                ->setEngFullMessage('This is Full Eng Message')
                ->setEngMessage('This is Short Eng Message')
                ->setShortMessage('This is Short Kor Message')
                ->setFullMessage('This is Full Kor Message')
                ->build();
        }catch(Exception $e){
            $this->assertEquals("Hiworks\AdminAuditLog\Exceptions\AdminAuditLogBuilderException :  [Not Valid Level] [user_name is not set] [user is not numeric]",
                get_class($e) . " : " . $e->getMessage());
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
             var_dump(get_class($e) . " : " . $e->getMessage());
         }
     }

    /**
     * Test Kafka Sending
     * @test
     * @throws Exception
     */
    function sendKafkaMessage_to_wrong_server()
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
            $admin_audit_log_producer = new AdminAuditLogKafkaProducer();
            //$logger = new Logger('my_logger');
            //$admin_audit_log_producer->setLogger($logger);
            //$kafkaConfig = $admin_audit_log_producer->getKafkaConfig();
            $admin_audit_log_producer->setBootstrapServer("THIS_IS_ERROR:10");
            $admin_audit_log_producer->sendMessage('tracking.admin.audit',$admin_audit_log);
        }catch(Exception $e){
            $this->assertEquals("Kafka\Exception : Not has broker can connection `metadataBrokerList`",
                get_class($e) . " : " . $e->getMessage());
        }
    }

    /**
     * Test Kafka Sending
     * @test
     * @throws Exception
     */
    function sendKafkaMessage_to_wrong_topic()
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
            $admin_audit_log_producer = new AdminAuditLogKafkaProducer();
            //$logger = new Logger('my_logger');
            //$admin_audit_log_producer->setLogger($logger);
            //$kafkaConfig = $admin_audit_log_producer->getKafkaConfig();
            $admin_audit_log_producer->setBootstrapServer("kafka01:9092,kafka02:9092,kafka03:9092");
            $admin_audit_log_producer->sendMessage('THIS_IS_ERROR',$admin_audit_log);
        }catch(Exception $e){
            $this->assertEquals("Hiworks\AdminAuditLog\Exceptions\AdminAuditLogException : Failed To Send Messages",
                get_class($e) . " : " . $e->getMessage());
        }
    }
    /**
     * Test Kafka Sending
     * @test
     * @throws Exception
     */
    function sendKafkaMessage_success()
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
            $admin_audit_log_producer = new AdminAuditLogKafkaProducer();
            //$logger = new Logger('my_logger');
            //$admin_audit_log_producer->setLogger($logger);
            //$kafkaConfig = $admin_audit_log_producer->getKafkaConfig();
            $admin_audit_log_producer->setBootstrapServer("kafka01:9092,kafka02:9092,kafka03:9092");
            $admin_audit_log_producer->sendMessage('tracking.admin.audit',$admin_audit_log);
        }catch(Exception $e){
            var_dump(get_class($e) . " : " . $e->getMessage());
        }
    }

    /**
     * Test Kafka Sending
     * @test
     * @throws Exception
     */
    function sendKafkaMessage_with_options()
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
            $admin_audit_log_producer = new AdminAuditLogKafkaProducer();
            $logger = new Logger('my_logger');
            $admin_audit_log_producer->setLogger($logger);
            $admin_audit_log_producer->setBootstrapServer("kafka01:9092,kafka02:9092,kafka03:9092");
            $admin_audit_log_producer->sendMessage('tracking.admin.audit',$admin_audit_log);
            $kafka_config = $admin_audit_log_producer->getKafkaConfig();
            $kafka_config->setRequireAck(1);
        }catch(Exception $e){
            var_dump(get_class($e) . " : " . $e->getMessage());
        }
    }


    /**
     * Not Working Well (Docker PHP)
     * @test
     */
//    function getKafkaMessages()
//    {
//        $logger = new Logger('my_logger');
//        $config = \Kafka\ConsumerConfig::getInstance();
//        $config->setMetadataRefreshIntervalMs(10000);
//        $config->setMetadataBrokerList('kafka01:9092,kafka02:9092,kafka03:9092');
//        $config->setGroupId('test');
//        $config->setBrokerVersion('0.10.1.0');
//        $config->setTopics(['tracking.admin.audit']);
//        $config->setOffsetReset('earliest');
//        $kafka_consumer = new \Kafka\Consumer();
//        //Debugging
//        $kafka_consumer->setLogger($logger);
//        $kafka_consumer->start(function($topic, $part, $message) {
//            var_dump($topic);
//            var_dump($message);
//        });
//    }

}