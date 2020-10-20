<?php
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

class KafkaGetTest extends \PHPUnit\Framework\TestCase
{
    /**
     *
     * @test
     */
    function getKafkaMessages()
    {
        $logger = new Logger('my_logger');
        $logger->pushHandler(new StreamHandler('php://stdout'));

        $config = \Kafka\ConsumerConfig::getInstance();
        $config->setMetadataRefreshIntervalMs(10000);
        $config->setMetadataBrokerList('kafka01:9092,kafka02:9092,kafka03:9092');
        $config->setGroupId('test');
        $config->setBrokerVersion('0.10.1.0');
        $config->setTopics(['tracking.admin.audit']);
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