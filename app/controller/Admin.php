<?php

namespace app\controller;

use app\model\Controller;
use app\model\Session;

class Admin extends Controller
{
    public function MethodGet() : void
    {
        $session = new Session($this);
        $session->RedirectNoAdmin();
        $session->ShowAllAlertAndClear();
    }
}

?>