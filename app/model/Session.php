<?php

namespace app\model;

class Session
{
    private Controller $_controller;
    private ?User $_user = null;

    function __construct(Controller $controller)
    {
        session_start();
        $this->_controller = $controller;

        if(isset($_SESSION['user']))
        {
            $user = unserialize($_SESSION['user']);
            if($user)
            {
                $this->_user = $user;
                $this->_controller->SetUserLogged($user);
            }
        }
    }

    public function GetController() : Controller
    {
        return $this->_controller;
    }

    public function GetUserLogged() : ?User
    {
        return $this->_user;
    }

    public function SetUserLogged(?User $user) : void
    {
        if(is_null($user))
            unset($_SESSION['user']);
        else
            $_SESSION['user'] = serialize($user);
        
        $this->_user = $user;
        $this->_controller->SetUserLogged($user);
    }

    public function AddAlert(Alert $alert) : void
    {
        if(!isset($_SESSION['alert']) || !is_array($_SESSION['alert']))
            $_SESSION['alert'] = [];
        $_SESSION['alert'][] = serialize($alert);
    }

    public function ShowAllAlertAndClear() : void
    {
        if(!isset($_SESSION['alert']) || !is_array($_SESSION['alert']))
            return;

        foreach ($_SESSION['alert'] as $alert)
        {
            $alert = unserialize($alert);
            if($alert)
                $this->_controller->AddAlert($alert);
        }

        self::ClearAlert();
    }

    public function ClearAlert() : void
    {
        unset($_SESSION['alert']);
    }

    public function RedirectConnected(string $page = 'home') : void
    {
        if(is_null($this->_user))
            return;
        
        $this->AddAlert(new Alert('Vous ne pouvez pas acceder à cette page en étant connecté', ));
        $this->_controller->Redirect($page);
    }

    public function RedirectNoAdmin(string $page = 'home') : void
    {
        if(!is_null($this->_user) && $this->_user->GetIsAdmin())
            return;
        
        $this->AddAlert(new Alert('Vous ne pouvez pas acceder à cette page', ));
        $this->_controller->Redirect($page);
    }
}

?>