<?php

namespace app\model;

use DateTime;

class User
{
    private int $_userID = 0;
    private ?string $_name = null;
    private ?string $_password = null;
    private ?Datetime $_registered = null;
    private bool $_isAdmin = false;

    public function GetID() : int
    {
        return $this->_userID;
    }

    public function SetID(int $userID) : void
    {
        $this->_userID = $userID;
    }

    public function GetName() : ?string
    {
        return $this->_name;
    }

    public function SetName(?string $name) : void
    {
        $this->_name = $name;
    }

    public function GetPassword() : ?string
    {
        return $this->_password;
    }

    public function SetPassword(?string $password) : void
    {
        $this->_password = $password;
    }

    public function GetRegistered() : ?DateTime
    {
        return $this->_registered;
    }

    public function SetRegistered(?DateTime $registered) : void
    {
        $this->_registered = $registered;
    }

    public function SetRegisteredString(string $string) : void
    {
        $this->_registered = new DateTime($string);
    }

    public function GetIsAdmin() : bool
    {
        return $this->_isAdmin;
    }

    public function SetIsAdmin(bool $isAdmin) : void
    {
        $this->_isAdmin = $isAdmin;
    }
}

?>