<?php
namespace Hiworks\AdminAuditLog\Producer;
use Hiworks\AdminAuditLog\AdminAuditLog;

Interface ProducerInterface
{
    /**
     * @param string $topic
     * @param AdminAuditLog $adminAuditLog
     * @return mixed
     */
    public function sendMessage($topic, AdminAuditLog$adminAuditLog);
}