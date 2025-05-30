<?php
// File: protected/components/UserIdentity.php

class UserIdentity extends CUserIdentity
{
    private $_id;

    public function authenticate()
    {
        $user = User::model()->findByAttributes(array('username' => $this->username));
        
        if($user === null)
            $this->errorCode = self::ERROR_USERNAME_INVALID;
        // Verifikasi password tanpa salt
        elseif($user->password !== md5($this->password))
            $this->errorCode = self::ERROR_PASSWORD_INVALID;
        else
        {
            $this->_id = $user->id;
            $this->setState('id', $user->id);
            $this->setState('name', $user->username);
            $this->errorCode = self::ERROR_NONE;
        }
        
        return !$this->errorCode;
    }

    public function getId()
    {
        return $this->_id;
    }
}