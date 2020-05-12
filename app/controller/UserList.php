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

        $get = $this->PrepareGet(['pn']);
        $pn = is_numeric($get->pn) && $get->pn > 0 ? (int)$get->pn : 1;
        $this->TemplateAddContext('pn', $pn);

        $this->TemplateAddContext('users', $userDAO->ReadList(--$pn*10));

    }
}

?>