<?php

namespace app\model;

Class User
{
    private $_userID;
    private $_name;
    private $_email;
    private $_password;
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

    public function GetName()
    {
        return $this->_name;
    }

    public function SetName($name)
    {
        $this->_name = $name;
    }

    public function GetEmail()
    {
        return $this->_email;
    }

    public function SetEmail($email)
    {
        $this->_email = $email;
    }

    public function GetPassword($password)
    {
        return $this->_password;
    }

    public function SetPassword($password)
    {
        $this->_password = $password;
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