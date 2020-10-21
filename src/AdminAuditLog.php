<?php
namespace Hiworks\AdminAuditLogBuilder;

use Hiworks\AdminAuditLogBuilder\Builder\AdminAuditLogBuilderV1;
use Hiworks\AdminAuditLogBuilder\Builder\AdminAuditLogBuilderInterface;
use Hiworks\AdminAuditLogBuilder\Exceptions\AdminAuditLogException;

class AdminAuditLog
{
    /**
     * @var string
     */
    private $version;

    /**
     * @var int
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
    private $_eng_message;

    /**
     * @var string
     */
    private $_eng_full_message;

    /**
     * @var int
     */
    private $_office;

    /**
     * @var int
     */
    private $_user;

    /**
     * @var string
     */
    private $_user_id;

    /**
     * @var string
     */
    private $_user_name;

    /**
     * @var string
     */
    private $_menu;

    /**
     * @var string
     */
    private $_access_ip;

    /**
     * @param string $builder_version
     * @return AdminAuditLogBuilderV1
     * @throws AdminAuditLogException
     */
    public static function builder($builder_version)
    {
        switch ($builder_version)
        {
            case 'v1':
                return new AdminAuditLogBuilderV1();
            default:
                throw new AdminAuditLogException(' Please Select Correct Version of Builder');
        }
    }

    public function __construct(AdminAuditLogBuilderInterface $adminAuditLogBuilder)
    {
        $adminAuditLogBuilder->setAdminAuditLog($this);
    }


    /**
     * @param string $version
     */
    public function setVersion($version)
    {
        $this->version = $version;
    }

    /**
     * @param int $host
     */
    public function setHost($host)
    {
        $this->host = $host;
    }

    /**
     * @param string $timestamp
     */
    public function setTimestamp($timestamp)
    {
        $this->timestamp = $timestamp;
    }

    /**
     * @param int $level
     */
    public function setLevel($level)
    {
        $this->level = $level;
    }

    /**
     * @param string $short_message
     */
    public function setShortMessage($short_message)
    {
        $this->short_message = $short_message;
    }

    /**
     * @param string $full_message
     */
    public function setFullMessage($full_message)
    {
        $this->full_message = $full_message;
    }

    /**
     * @param string $eng_message
     */
    public function setEngMessage($eng_message)
    {
        $this->_eng_message = $eng_message;
    }

    /**
     * @param string $eng_full_message
     */
    public function setEngFullMessage($eng_full_message)
    {
        $this->_eng_full_message = $eng_full_message;
    }

    /**
     * @param int $office
     */
    public function setOffice($office)
    {
        $this->_office = $office;
    }

    /**
     * @param int $user
     */
    public function setUser($user)
    {
        $this->_user = $user;
    }

    /**
     * @param string $user_id
     */
    public function setUserId($user_id)
    {
        $this->_user_id = $user_id;
    }

    /**
     * @param string $user_name
     */
    public function setUserName($user_name)
    {
        $this->_user_name = $user_name;
    }

    /**
     * @param string $menu
     */
    public function setMenu($menu)
    {
        $this->_menu = $menu;
    }

    /**
     * @param string $access_ip
     */
    public function setAccessIp($access_ip)
    {
        $this->_access_ip = $access_ip;
    }


}
