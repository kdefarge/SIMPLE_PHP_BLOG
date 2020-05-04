<?php

namespace app\model;

Class User
{
    private $_userID;
    private $_userName;
    private $_email;
    private $_registered;
    private $_isAdmin;

    public function GetID()
    {
        return $this->_userID;
    }

    public function SetID($userID)
    {
        $this->_userID = $userID;
    }

    public function GetUserName()
    {
        return $this->_userName;
    }

    public function SetUserName($userName)
    {
        $this->_userName = $userName;
    }

    public function GetEmail()
    {
        return $this->_email;
    }

    public function SetEmail($email)
    {
        $this->_email = $email;
    }

    public function GetRegistered()
    {
        return $this->_registered;
    }

    public function SetRegistered($registered)
    {
        $this->_registered = $registered;
    }

    public function GetIsAdmin()
    {
        return $this->$_isAdmin;
    }

    public function SetIsAdmin($isAdmin)
    {
        $this->_isAdmin = $isAdmin;
    }
}

?>