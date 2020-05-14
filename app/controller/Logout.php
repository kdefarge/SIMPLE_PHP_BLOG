<?php

namespace app\controller;

use app\model\Controller;
use app\model\Utils;
use app\model\Session;

class Logout extends Controller
{
    public function MethodGet() : void
    {
        $session = new Session($this);
        $session->SetUserLogged(null);

        $utils = new Utils();
        $utils->EnableAlert_Redirect($session);
        $utils->AddInfo('Vous êtes déconnecté');
        $this->Redirect();
    }
}

?>