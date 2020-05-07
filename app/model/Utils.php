<?php

namespace app\model;

class Utils
{
    private Controller $_controller;

    public function SetController(Controller $controller) : void
    {
        $this->_controller = $controller;
    }

    public function GetController() : Controller
    {
        return $this->_controller;
    }

    public function AddError(string $text) : void
    {
        $alert = new Alert($text);
        $this->GetController()->AddAlert($alert);
    }

    public function Die(string $text) : void
    {
        self::AddError($text);
        $this->GetController()->Die();
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
}

?>