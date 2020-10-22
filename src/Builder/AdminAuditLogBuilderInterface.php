<?php

namespace Hiworks\AdminAuditLog\Builder;


use Hiworks\AdminAuditLog\AdminAuditLog;
use Hiworks\AdminAuditLog\Exceptions\AdminAuditLogException;

Interface AdminAuditLogBuilderInterface
{
    /**
     * @return AdminAuditLog
     * @throws AdminAuditLogException
     */
    public function build();

    /**
     * Setting ErrorMessage (Validation)
     */
    public function validateProperties();

    /**
     * Setting Unix MicroTimeStamp
     */
    public function setDefaultTimestamp();

    /**
     * Setting AdminAuditLog
     * @param AdminAuditLog $adminAuditLog
     * @return AdminAuditLog
     */
    public function setAdminAuditLog($adminAuditLog);
}