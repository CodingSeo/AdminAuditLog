<?php

namespace Hiworks\AdminAuditLogBuilder\Builder;

use Hiworks\AdminAuditLogBuilder\Dtos\AdminAuditLogDTO;
use Hiworks\AdminAuditLogBuilder\Config\AdminAuditLogConfigInterface;

interface AdminAuditLogBuilderInterface
{

    /**
     * @param AdminAuditLogConfigInterface $adminAuditLogConfig
     */
    public function setConfig(AdminAuditLogConfigInterface $adminAuditLogConfig);
    /**
     * @return bool|AdminAuditLogDTO
     */
    public function build();
}