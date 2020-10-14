<?php

namespace Hiworks\AdminAuditLogProducer\Builder;

use Hiworks\AdminAuditLogProducer\Dtos\AdminAuditLogDTO;
use Hiworks\AdminAuditLogProducer\Config\AdminAuditLogConfigInterface;

interface AdminAuditLogBuilderInterface
{

    /**
     * @param AdminAuditLogConfigInterface $adminAuditLogConfig
     */
    public function setConfig(AdminAuditLogConfigInterface $adminAuditLogConfig);
    /**
     * @return $this|AdminAuditLogBuilder
     */
    public function loadAdminAuditLogDTO();
    /**
     * @return bool|AdminAuditLogDTO
     */
    public function build();
}