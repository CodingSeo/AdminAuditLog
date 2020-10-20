<?php


namespace Hiworks\AdminAuditLogBuilder\Config;

use Hiworks\AdminAuditLogBuilder\Dtos\AdminAuditLogDTO;
use Hiworks\AdminAuditLogBuilder\Enums\LevelType;
use Hiworks\AdminAuditLogBuilder\Enums\MenuCodeType;
use Hiworks\AdminAuditLogBuilder\Exceptions\AdminAuditLogException;

class AdminAuditLogConfig implements AdminAuditLogConfigInterface
{
    private $version;
    private $host;

    public function __construct()
    {
        $this->version = 1.1;
        $this->host = '127.0.0.1';
    }

    /**
     * @param AdminAuditLogDTO $admin_audit_log_dto
     */
    public function setDefault(AdminAuditLogDTO $admin_audit_log_dto)
    {
        $admin_audit_log_dto->setVersion($this->version);
        $admin_audit_log_dto->setHost($this->host);
        $admin_audit_log_dto->setTimestamp($this->getMicroUnixTime());
    }

    /**
     * Setting TimeStamp according to UTC and return to default;
     * @return string
     */
    public function getMicroUnixTime()
    {
        $prev_timezone = date_default_timezone_get()?date_default_timezone_get():"UTC";
        date_default_timezone_set('UTC');
        $timestamp = sprintf('%.6F', microtime(true));
        if($prev_timezone !=="UTC"){
            date_default_timezone_set($prev_timezone);
        }
        return $timestamp;
    }

    /**
     * @param AdminAuditLogDTO $admin_audit_log_dto
     * @return bool|void
     * @throws AdminAuditLogException
     */
    public function validate(AdminAuditLogDTO $admin_audit_log_dto)
    {
        $error_message = "";
        if(!LevelType::isValid($admin_audit_log_dto->getLevel())) $error_message .= ' [Not Valid Level]';
        if(!MenuCodeType::isValid($admin_audit_log_dto->getMenu())) $error_message .= ' [Not Valid Menu]';

        if($admin_audit_log_dto->getShortMessage() === null) $error_message .= ' [short_korean is not set]';
        if($admin_audit_log_dto->getEngMessage() === null) $error_message .= ' [eng_message is not set]';
        if($admin_audit_log_dto->getFullMessage() === null) $error_message .= ' [full_korean is not set]';
        if($admin_audit_log_dto->getEngFullMessage() === null) $error_message .= ' [full_eng_message is not set]';
        if($admin_audit_log_dto->getTimestamp() === null) $error_message .= ' [time_stamp is not set]';
        if($admin_audit_log_dto->getUserName() === null) $error_message .= ' [user_name is not set]';
        if($admin_audit_log_dto->getUserId() === null) $error_message .= ' [user_id is not set]';

        $ip = $admin_audit_log_dto->getAccessIp();
        if($ip === null) $error_message .= ' [_access_ip is not set]';
        elseif(!$this->validateIP($ip)) $error_message .= ' [_access_ip is IPv4 format]';

        $office_num = $admin_audit_log_dto->getOffice();
        if($office_num === null) $error_message .= ' [office is not set]';
        elseif (!$this->validateNumeric($office_num)) $error_message .= ' [office is not numeric]';

        $user_num = $admin_audit_log_dto->getUser();
        if($user_num === null) $error_message .= ' [user_num is not set]';
        elseif (!$this->validateNumeric($user_num)) $error_message .= ' [user_num is not numeric]';

        if($error_message !="")
        {
            throw new AdminAuditLogException($error_message);
        }
        return true;
    }

    /**
     * @param string $ip
     * @return mixed
     */
    public function validateIP($ip)
    {
        return filter_var($ip,FILTER_VALIDATE_IP);
    }

    /**
     * @param mixed $value
     * @return bool
     */
    public function validateNumeric($value)
    {
        return is_numeric($value);
    }

}