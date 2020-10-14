<?php
namespace Hiworks\AdminAuditLogBuilder\Dtos;
/**
 * Class AdminAuditLogDTO
 * @package Hiworks\AdminAuditLogBuilder\Dtos
 */
class AdminAuditLogDTO
{
    /**
     * @var int
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
     * @return int
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * @param int $version
     */
    public function setVersion($version)
    {
        $this->version = $version;
    }

    /**
     * @return int
     */
    public function getHost()
    {
        return $this->host;
    }

    /**
     * @param int $host
     */
    public function setHost($host)
    {
        $this->host = $host;
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
     */
    public function setTimestamp($timestamp)
    {
        $this->timestamp = $timestamp;
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
     */
    public function setShortMessage($short_message)
    {
        $this->short_message = $short_message;
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
     */
    public function setFullMessage($full_message)
    {
        $this->full_message = $full_message;
    }

    /**
     * @return string
     */
    public function getEngMessage()
    {
        return $this->_eng_message;
    }

    /**
     * @param string $eng_message
     */
    public function setEngMessage($eng_message)
    {
        $this->_eng_message = $eng_message;
    }

    /**
     * @return string
     */
    public function getEngFullMessage()
    {
        return $this->_eng_full_message;
    }

    /**
     * @param string $eng_full_message
     */
    public function setEngFullMessage($eng_full_message)
    {
        $this->_eng_full_message = $eng_full_message;
    }

    /**
     * @return int
     */
    public function getOffice()
    {
        return $this->_office;
    }

    /**
     * @param int $office
     */
    public function setOffice($office)
    {
        $this->_office = $office;
    }

    /**
     * @return int
     */
    public function getUser()
    {
        return $this->_user;
    }

    /**
     * @param int $user
     */
    public function setUser($user)
    {
        $this->_user = $user;
    }

    /**
     * @return string
     */
    public function getUserId()
    {
        return $this->_user_id;
    }

    /**
     * @param string $user_id
     */
    public function setUserId($user_id)
    {
        $this->_user_id = $user_id;
    }

    /**
     * @return string
     */
    public function getUserName()
    {
        return $this->_user_name;
    }

    /**
     * @param string $user_name
     */
    public function setUserName($user_name)
    {
        $this->_user_name = $user_name;
    }

    /**
     * @return string
     */
    public function getMenu()
    {
        return $this->_menu;
    }

    /**
     * @param string $menu
     */
    public function setMenu($menu)
    {
        $this->_menu = $menu;
    }

    /**
     * @return string
     */
    public function getAccessIp()
    {
        return $this->_access_ip;
    }

    /**
     * @param string $access_ip
     */
    public function setAccessIp($access_ip)
    {
        $this->_access_ip = $access_ip;
    }
}