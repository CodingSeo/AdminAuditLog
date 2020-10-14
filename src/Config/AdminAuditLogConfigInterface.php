<?php

namespace Hiworks\AdminAuditLogProducer\Config;

use Hiworks\AdminAuditLogProducer\Dtos\AdminAuditLogDTO;
use Hiworks\AdminAuditLogProducer\Exceptions\AdminAuditLogException;

interface AdminAuditLogConfigInterface
{
    /**
     * @param AdminAuditLogDTO $admin_audit_log_dto
     * @return void
     */
    function setDefault(AdminAuditLogDTO $admin_audit_log_dto);

    /**
     * @return string
     */
    function setMicroUnixTime();

    /**
     * @param AdminAuditLogDTO $admin_audit_log_dto
     * @return bool|void
     * @throws AdminAuditLogException
     */
    function validate(AdminAuditLogDTO $admin_audit_log_dto);
}