<?php
namespace Hiworks\AdminAuditLogBuilder\Builder;


use Hiworks\AdminAuditLogBuilder\AdminAuditLog;
use Hiworks\AdminAuditLogBuilder\Enums\LevelType;
use Hiworks\AdminAuditLogBuilder\Enums\MenuCodeType;
use Hiworks\AdminAuditLogBuilder\Exceptions\AdminAuditLogException;

class AdminAuditLogBuilder
{
    /**
     * @var string
     */
    private $error_message = "";

    /**
     * @var int
     */
    private $version;

    /**
     * @var string
     */
    private $host;

    /**
     * @var string
     */
    private $timestamp;

    /**
     * @var int
     */
    private $level;

    /**
     * @var string
     */
    private $short_message;

    /**
     * @var string
     */
    private $full_message;

    /**
     * @var string
     */
    private $eng_message;

    /**
     * @var string
     */
    private $eng_full_message;

    /**
     * @var int
     */
    private $office;

    /**
     * @var int
     */
    private $user;

    /**
     * @var string
     */
    private $user_id;

    /**
     * @var string
     */
    private $user_name;

    /**
     * @var string
     */
    private $menu;

    /**
     * @var string
     */
    private $access_ip;

    public function __construct()
    {
        $this->setDefaultTimestamp();
        $this->setDefaultVersion();
    }

    /**
     * @return AdminAuditLog
     * @throws AdminAuditLogException
     */
    public function build()
    {
        $this->setErrorMessage();
        if(!$this->error_message == "")
        {
            throw new AdminAuditLogException($this->error_message);
        }
        return new AdminAuditLog($this);
    }

    /**
     * Setting ErrorMessage (Validation)
     */
    public function setErrorMessage()
    {
        if(!LevelType::isValid($this->getLevel())) $this->error_message .= ' [Not Valid Level]';
        if(!MenuCodeType::isValid($this->getMenu())) $this->error_message .= ' [Not Valid Menu]';

        if($this->getShortMessage() === null) $this->error_message .= ' [short_korean is not set]';
        if($this->getEngMessage() === null) $this->error_message .= ' [eng_message is not set]';
        if($this->getFullMessage() === null) $this->error_message .= ' [full_korean is not set]';
        if($this->getEngFullMessage() === null) $this->error_message .= ' [full_eng_message is not set]';
        if($this->getTimestamp() === null) $this->error_message .= ' [time_stamp is not set]';
        if($this->getUserName() === null) $this->error_message .= ' [user_name is not set]';
        if($this->getUserId() === null) $this->error_message .= ' [user_id is not set]';
        if($this->getOffice() === null) $this->error_message .= ' [office is not set]';
        if($this->getUser() === null) $this->error_message .= ' [user_num is not set]';

        $ip = $this->getAccessIp();
        if($ip === null) $this->error_message .= ' [_access_ip is not set]';
        elseif(!$this->validateIP($ip)) $this->error_message .= ' [_access_ip is not IPv4 format]';

        $host = $this->getHost();
        if($host === null) $this->error_message .= ' [host is not set]';
        elseif(!$this->validateIP($host)) $this->error_message .= ' [host is not IPv4 format]';
    }

    /**
     * Setting Unix MicroTimeStamp
     */
    public function setDefaultTimestamp()
    {
        $prev_timezone = date_default_timezone_get()?date_default_timezone_get():"UTC";
        date_default_timezone_set('UTC');
        $timestamp = sprintf('%.6F', microtime(true));
        if($prev_timezone !=="UTC"){
            date_default_timezone_set($prev_timezone);
        }
        $this->timestamp = $timestamp;
    }

    /**
     * Setting Version
     */
    public function setDefaultVersion()
    {
        $this->version = "1.1";
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
     * @return string
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * @param string $version
     * @return $this
     */
    public function setVersion($version)
    {
        $this->version = $version;
        return $this;
    }

    /**
     * @return string
     */
    public function getHost()
    {
        return $this->host;
    }

    /**
     * @param string $host
     * @return $this
     */
    public function setHost($host)
    {
        $this->host = $host;
        return $this;
    }

    /**
     * @return string
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * @param string $timestamp
     * @return AdminAuditLogBuilder
     */
    public function setTimestamp($timestamp)
    {
        $this->timestamp = $timestamp;
        return $this;
    }

    /**
     * @return int
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * @param int $level
     */
    public function setLevel($level)
    {
        $this->level = $level;
        return $this;
    }

    /**
     * @return string
     */
    public function getShortMessage()
    {
        return $this->short_message;
    }

    /**
     * @param string $short_message
     * @return AdminAuditLogBuilder
     */
    public function setShortMessage($short_message)
    {
        $this->short_message = $short_message;
        return $this;
    }

    /**
     * @return string
     */
    public function getFullMessage()
    {
        return $this->full_message;
    }

    /**
     * @param string $full_message
     * @return AdminAuditLogBuilder
     */
    public function setFullMessage($full_message)
    {
        $this->full_message = $full_message;
        return $this;
    }

    /**
     * @return string
     */
    public function getEngMessage()
    {
        return $this->eng_message;
    }

    /**
     * @param string $eng_message
     * @return AdminAuditLogBuilder
     */
    public function setEngMessage($eng_message)
    {
        $this->eng_message = $eng_message;
        return $this;
    }

    /**
     * @return string
     */
    public function getEngFullMessage()
    {
        return $this->eng_full_message;
    }

    /**
     * @param string $eng_full_message
     * @return AdminAuditLogBuilder
     */
    public function setEngFullMessage($eng_full_message)
    {
        $this->eng_full_message = $eng_full_message;
        return $this;
    }

    /**
     * @return int
     */
    public function getOffice()
    {
        return $this->office;
    }

    /**
     * @param int $office
     * @return AdminAuditLogBuilder
     */
    public function setOfficeNum($office)
    {
        $this->office = $office;
        return $this;
    }

    /**
     * @return int
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param int $user
     */
    public function setUserNum($user)
    {
        $this->user = $user;
        return $this;
    }

    /**
     * @return string
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * @param string $user_id
     * @return AdminAuditLogBuilder
     */
    public function setUserId($user_id)
    {
        $this->user_id = $user_id;
        return $this;
    }

    /**
     * @return string
     */
    public function getUserName()
    {
        return $this->user_name;
    }

    /**
     * @param string $user_name
     * @return AdminAuditLogBuilder
     */
    public function setUserName($user_name)
    {
        $this->user_name = $user_name;
        return $this;
    }

    /**
     * @return string
     */
    public function getMenu()
    {
        return $this->menu;
    }

    /**
     * @param string $menu
     * @return AdminAuditLogBuilder
     */
    public function setMenu($menu)
    {
        $this->menu = $menu;
        return $this;
    }

    /**
     * @return string
     */
    public function getAccessIp()
    {
        return $this->access_ip;
    }

    /**
     * @param string $access_ip
     * @return AdminAuditLogBuilder
     */
    public function setAccessIp($access_ip)
    {
        $this->access_ip = $access_ip;
        return $this;
    }

}