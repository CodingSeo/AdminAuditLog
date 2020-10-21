<?php
namespace Hiworks\AdminAuditLog\Builder;


use Hiworks\AdminAuditLog\AdminAuditLog;
use Hiworks\AdminAuditLog\Enums\LevelType;
use Hiworks\AdminAuditLog\Enums\MenuCodeType;
use Hiworks\AdminAuditLog\Exceptions\AdminAuditLogException;

class AdminAuditLogBuilderV1 implements AdminAuditLogBuilderInterface
{
    /**
     * @var string
     */
    private $error_message = "";

    /**
     * @var string
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
        $this->setDefaultHost();
    }

    /**
     * @return AdminAuditLog
     * @throws AdminAuditLogException
     */
    public function build()
    {
        $this->validateProperties();
        if(!$this->error_message == "")
        {
            throw new AdminAuditLogException($this->error_message);
        }
        return new AdminAuditLog($this);
    }

    /**
     * @param AdminAuditLog $adminAuditLog
     * @return AdminAuditLog
     */
    public function setAdminAuditLog($adminAuditLog)
    {
        $adminAuditLog->setUserId($this->getUserId());
        $adminAuditLog->setTimestamp($this->getTimestamp());
        $adminAuditLog->setUser($this->getUser());
        $adminAuditLog->setUserName($this->getUserName());
        $adminAuditLog->setOffice($this->getOffice());
        $adminAuditLog->setMenu($this->getMenu());
        $adminAuditLog->setLevel($this->getLevel());
        $adminAuditLog->setVersion($this->getVersion());
        $adminAuditLog->setHost($this->getHost());
        $adminAuditLog->setEngMessage($this->getEngMessage());
        $adminAuditLog->setEngFullMessage($this->getEngFullMessage());
        $adminAuditLog->setShortMessage($this->getShortMessage());
        $adminAuditLog->setFullMessage($this->getFullMessage());
        $adminAuditLog->setAccessIp($this->getAccessIp());
        return $adminAuditLog;
    }

    /**
     * Setting ErrorMessage (Validation)
     */
    public function validateProperties()
    {
        if(!LevelType::isValid($this->getLevel())) $this->error_message .= ' [Not Valid Level]';
        if(!MenuCodeType::isValid($this->getMenu())) $this->error_message .= ' [Not Valid Menu]';

        if(empty($this->getShortMessage())) $this->error_message .= ' [short_korean is not set]';
        if(empty($this->getEngMessage())) $this->error_message .= ' [eng_message is not set]';
        if(empty($this->getFullMessage())) $this->error_message .= ' [full_korean is not set]';
        if(empty($this->getEngFullMessage())) $this->error_message .= ' [full_eng_message is not set]';
        if(empty($this->getTimestamp())) $this->error_message .= ' [time_stamp is not set]';
        if(empty($this->getUserName())) $this->error_message .= ' [user_name is not set]';
        if(empty($this->getUserId())) $this->error_message .= ' [user_id is not set]';
        if(empty($this->getOffice())) $this->error_message .= ' [office is not set]';
        if(empty($this->getUser())) $this->error_message .= ' [user_num is not set]';

        $ip = $this->getAccessIp();
        if(empty($ip)) $this->error_message .= ' [_access_ip is not set]';
        elseif(!$this->validateIPv4($ip)) $this->error_message .= ' [_access_ip is not IPv4 format]';

        $host = $this->getHost();
        if(empty($host)) $this->error_message .= ' [host is not set]';
        elseif(!$this->validateIPv4($host)) $this->error_message .= ' [host is not IPv4 format]';
    }

    /**
     * Setting Unix MicroTimeStamp
     */
    public function setDefaultTimestamp()
    {
        $this->timestamp = sprintf('%.6F', microtime(true));
    }

    /**
     * Setting Version
     */
    public function setDefaultVersion()
    {
        $this->version = "1.1";
    }

    /**
     * Setting Default Host
     */
    public function setDefaultHost()
    {
        $this->host = '127.0.0.1';
    }

    /**
     * @param string $ip
     * @return mixed
     */
    public function validateIPv4($ip)
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
     * @return string
     */
    public function getTimestamp()
    {
        return $this->timestamp;
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
     * @return AdminAuditLogV1
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
     * @return AdminAuditLogV1
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
     * @return AdminAuditLogV1
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
     * @return AdminAuditLogV1
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
     * @return AdminAuditLogV1
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
     * @return AdminAuditLogV1
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
     * @return AdminAuditLogV1
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
     * @return AdminAuditLogV1
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
     * @return AdminAuditLogV1
     */
    public function setAccessIp($access_ip)
    {
        $this->access_ip = $access_ip;
        return $this;
    }
}