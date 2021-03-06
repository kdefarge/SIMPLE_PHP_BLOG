<?php

namespace app\model;

class Utils
{
    private ?Controller $_controller = null;
    private ?Session $_session = null;

    public function EnableAlert_Direct(Controller $controller) : void
    {
        $this->_controller = $controller;
        $this->_session = null;
    }

    public function GetController() : ?Controller
    {
        return $this->_controller;
    }

    public function EnableAlert_Redirect(Session $session) : void
    {
        $this->_controller = null;
        $this->_session = $session;
    }

    public function GetSession() : ?Session
    {
        return $this->_session;
    }

    public function AddError(string $text) : void
    {
        $alert = new Alert($text);
        $this->AddAlert($alert);        
    }

    public function AddValide(string $text) : void
    {
        $alert = new Alert($text, Alert::TYPE_SUCCESS);
        $this->AddAlert($alert);        
    }

    public function AddInfo(string $text) : void
    {
        $alert = new Alert($text, Alert::TYPE_INFO);
        $this->AddAlert($alert);        
    }

    public function AddAlert(Alert $alert) : void
    {
        if($this->_session !== null)
        {
            $this->_session->AddAlert($alert);
        }
        elseif($this->_controller !== null)
        {
            $this->_controller->AddAlert($alert);
        }
    }

    public function Die(string $text) : void
    {
        if($this->_session !== null)
        {
            $this->_session->GetController()->Die(new Alert($text));
        }
        elseif($this->_controller !== null)
        {            
            $this->_controller->Die(new Alert($text));
        }
        else
        {
            Die($text);
        }
    }

    public function NotBlank(string $name, string $value) : bool
    {
        if(!empty($value))
            return true;
    
        $this->AddError('Le champ '.$name.' saisi est vide');
        return false;
    }

    public function MinLength(string $name, string $value, int $minSize) : bool
    {
        if(strlen($value) >= $minSize)
            return true;
    
        $this->AddError('Le champ '.$name.' doit contenir au moins '.$minSize.' caractères');
        return false;
    }

    public function MaxLength(string $name, string $value, int $maxSize) : bool
    {
        if(strlen($value) <= $maxSize)
            return true;

        $this->AddError('Le champ '.$name.' doit contenir au maximum '.$maxSize.' caractères');
        return false;
    }

    public function ValidateEmail(string $name, string $value) : bool
    {
        if(filter_var($value, FILTER_VALIDATE_EMAIL))
            return true;

        $this->AddError('Le champ '.$name.' n\'est pas une adresse valide');
        return false;
    }
}

?>