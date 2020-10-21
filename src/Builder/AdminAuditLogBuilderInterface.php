<?php

namespace Hiworks\AdminAuditLogBuilder\Builder;


use Hiworks\AdminAuditLogBuilder\AdminAuditLog;
use Hiworks\AdminAuditLogBuilder\Exceptions\AdminAuditLogException;

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
     * @param AdminAuditLog $adminAuditLog
     * @return AdminAuditLog
     * Setting AdminAuditLog
     */
    public function setAdminAuditLog($adminAuditLog);
}