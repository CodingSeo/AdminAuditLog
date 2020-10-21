<?php

namespace Hiworks\AdminAuditLog\Exceptions;
use Exception;

class AdminAuditLogException extends Exception
{
    /**
     * {@inheritdoc}
     */
    protected $message = 'AdminAuditLog Exception Occurred';

    public function __construct($message = null)
    {
        if($message != null){
            $this->message = $this->message." :".$message;
        }
    }
}
