<?php
namespace Hiworks\AdminAuditLog\Producer;

use Exception;
use Hiworks\AdminAuditLog\AdminAuditLog;
use Hiworks\KafkaProducer\Producer;
use Hiworks\KafkaProducer\ProducerConfig;

class AdminAuditLogKafkaProducer implements ProducerInterface
{

    /**
     * @var ProducerConfig
     */
    private $kafka_config;

    private $logger = null;

    public function __construct()
    {
        $this->kafka_config = new ProducerConfig();
    }

    /**
     * @param string $bootstrapServer
     */
    public function setBootstrapServer($bootstrapServer)
    {
        $this->kafka_config->setBootstrapServer($bootstrapServer);
    }

    /**
     * @param string $topic
     * @param AdminAuditLog $adminAuditLog
     * @return void
     * @throws Exception
     */
    public function sendMessage($topic,AdminAuditLog $adminAuditLog)
    {
        $kafka_producer = new Producer($this->kafka_config);
        if($this->logger != null){
            $kafka_producer->setLogger($this->logger);
        }
        $kafka_producer->send($topic,$adminAuditLog);
    }

    public function setLogger($logger)
    {
        $this->logger = $logger;
    }
}