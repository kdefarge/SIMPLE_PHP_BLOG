<?php

namespace app\controller;

use app\model\Controller;
use app\model\Session;

class Home extends Controller
{
    public function MethodGet() : void
    {
        $session = new Session($this);
        $session->ShowAllAlertAndClear();
    }
}

?>