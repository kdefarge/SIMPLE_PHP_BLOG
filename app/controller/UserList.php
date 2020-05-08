<?php

namespace app\controller;

use app\model\Controller;
use app\model\Utils;
use app\model\Session;
use app\model\UserUtils;
use app\model\UserDAO;

class UserList extends Controller
{
    public function MethodGet() : void
    {
        $session = new Session($this);
        $session->RedirectNoAdmin();
        $session->ShowAllAlertAndClear();

        $userUtils = new UserUtils();
        $userUtils->EnableAlert_Direct($this);

        $userDAO = new UserDAO();
        $userDAO->SetUtils($userUtils);
        $this->TemplateAddContext('users', $userDAO->ReadList());
    }
}

?>