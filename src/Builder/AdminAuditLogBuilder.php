<?php
namespace Hiworks\AdminAuditLogBuilder\Builder;

use Hiworks\AdminAuditLogBuilder\Dtos\AdminAuditLogDTO;
use Hiworks\AdminAuditLogBuilder\Config\AdminAuditLogConfigInterface;
use Hiworks\AdminAuditLogBuilder\Exceptions\AdminAuditLogException;

class AdminAuditLogBuilder implements AdminAuditLogBuilderInterface
{
    /**
     * @var AdminAuditLogDTO
     */
    private $admin_audit_log_dto;

    /**
     * @var AdminAuditLogConfigInterface
     */
    private $admin_default_config;

    public function __construct()
    {

    }

    /**
     * @param AdminAuditLogConfigInterface $admin_default_config
     * @return $this
     */
    public function setConfig(AdminAuditLogConfigInterface $admin_default_config)
    {
        $this->admin_default_config = $admin_default_config;
        return $this;
    }


    /**
     * @return $this
     */
    public function loadAdminAuditLogDTO()
    {
        $this->admin_audit_log_dto = new AdminAuditLogDTO();
        if($this->admin_default_config !== null){
            $this->admin_default_config->setDefault($this->admin_audit_log_dto);
        }
        return $this;
    }

    /**
     * @return bool|AdminAuditLogDTO
     * @throws AdminAuditLogException
     */
    public function build()
    {
        if($this->admin_default_config->validate($this->admin_audit_log_dto))
        {
            return $this->admin_audit_log_dto;
        }
        return false;
    }

    /**
     * @param string $timestamp
     * @return $this
     */
    public function setTimestamp($timestamp)
    {
        $this->admin_audit_log_dto->setTimestamp($timestamp);
        return $this;
    }

    /**
     * @param int $level
     * @return $this
     */
    public function setLevel($level)
    {
        $this->admin_audit_log_dto->setLevel($level);
        return $this;
    }

    /**
     * @param string $short_message
     * @return $this
     */
    public function setShortMessage($short_message)
    {
        $this->admin_audit_log_dto->setShortMessage($short_message);
        return $this;
    }

    /**
     * @param string $full_message
     * @return $this
     */
    public function setFullMessage($full_message)
    {
        $this->admin_audit_log_dto->setFullMessage($full_message);
        return $this;
    }

    /**
     * @param string $eng_message
     * @return $this
     */
    public function setEngMessage($eng_message)
    {
        $this->admin_audit_log_dto->setEngMessage($eng_message);
        return $this;
    }


    /**
     * @param string $eng_full_message
     * @return $this
     */
    public function setEngFullMessage($eng_full_message)
    {
        $this->admin_audit_log_dto->setEngFullMessage($eng_full_message);
        return $this;
    }


    /**
     * @param int $office
     * @return $this
     */
    public function setOfficeNum($office)
    {
        $this->admin_audit_log_dto->setOffice($office);
        return $this;
    }

    /**
     * @param int $user
     * @return $this
     */
    public function setUserNum($user)
    {
        $this->admin_audit_log_dto->setUser($user);
        return $this;
    }


    /**
     * @param string $user_id
     * @return $this
     */
    public function setUserId($user_id)
    {
        $this->admin_audit_log_dto->setUserId($user_id);
        return $this;
    }


    /**
     * @param string $user_name
     * @return $this
     */
    public function setUserName($user_name)
    {
        $this->admin_audit_log_dto->setUserName($user_name);
        return $this;
    }


    /**
     * @param string $menu
     * @return $this
     */
    public function setMenu($menu)
    {
        $this->admin_audit_log_dto->setMenu($menu);
        return $this;
    }


    /**
     * @param string $access_ip
     * @return $this
     */
    public function setAccessIp($access_ip)
    {
        $this->admin_audit_log_dto->setAccessIp($access_ip);
        return $this;
    }
}