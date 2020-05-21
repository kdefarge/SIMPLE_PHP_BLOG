<?php

namespace app\model;

class Core
{
    private Superglobal $superglobal;
    private Controller $controller;
    //private Session $session;
    //private Template $template;
    //private AlertManager $alertManager;

    function __construct()
    {
        $this->superglobal = new Superglobal(); 
        //$this->session =  new Session($this);
    }

    public function get_superglobal() : Superglobal
    {
        return $this->superglobal;
    }

    public function set_controller(Controller $controller) : void
    {
        $this->controller = $controller;
    }

    public function get_controller() : Controller
    {
        return $this->controller;
    }
}

?>