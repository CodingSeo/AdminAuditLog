<?php


namespace Hiworks\AdminAuditLogProducer\Config;

use Hiworks\AdminAuditLogProducer\Dtos\AdminAuditLogDTO;
use Hiworks\AdminAuditLogProducer\Enums\LevelType;
use Hiworks\AdminAuditLogProducer\Enums\MenuCodeType;
use Hiworks\AdminAuditLogProducer\Exceptions\AdminAuditLogException;

class AdminAuditLogConfig_V1 implements AdminAuditLogConfigInterface
{
    /**
     * @param AdminAuditLogDTO $admin_audit_log_dto
     */
    function setDefault(AdminAuditLogDTO $admin_audit_log_dto)
    {
        $admin_audit_log_dto->setVersion(1.1);
        $admin_audit_log_dto->setHost('127.0.0.1');
        $admin_audit_log_dto->setTimestamp($this->setMicroUnixTime());
    }

    /**
     * @return string
     */
    function setMicroUnixTime()
    {
        date_default_timezone_get()!=="" ?: date_default_timezone_set('PRC');
        return sprintf('%.6F', microtime(true));
    }

    /**
     * @param AdminAuditLogDTO $admin_audit_log_dto
     * @return bool|void
     * @throws AdminAuditLogException
     */
    function validate(AdminAuditLogDTO $admin_audit_log_dto)
    {
        $error_message = "";
        if(!LevelType::isValid($admin_audit_log_dto->getLevel())) $error_message .= ' [Not Valid Level]';
        if(!MenuCodeType::isValid($admin_audit_log_dto->getMenu())) $error_message .= ' [Not Valid Menu]';
        if($admin_audit_log_dto->getShortMessage() === null) $error_message .= ' [short_korean is not set]';
        if($admin_audit_log_dto->getEngMessage() === null) $error_message .= ' [eng_message is not set]';
        if($admin_audit_log_dto->getFullMessage() === null) $error_message .= ' [full_korean is not set]';
        if($admin_audit_log_dto->getEngFullMessage() === null) $error_message .= ' [full_eng_message is not set]';
        if($admin_audit_log_dto->getAccessIp() === null) $error_message .= ' [_access_ip is not set]';
        if($admin_audit_log_dto->getOffice() === null) $error_message .= ' [office is not set]';
        if($admin_audit_log_dto->getUser() === null) $error_message .= ' [user_num is not set]';
        if($admin_audit_log_dto->getTimestamp() === null) $error_message .= ' [time_stamp is not set]';
        if($admin_audit_log_dto->getUserName() === null) $error_message .= ' [user_name is not set]';
        if($admin_audit_log_dto->getUserId() === null) $error_message .= ' [user_id is not set]';
        if($error_message !="")
        {
            throw new AdminAuditLogException($error_message);
        }
        return true;
    }

}