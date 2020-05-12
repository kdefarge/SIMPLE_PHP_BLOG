<?php

namespace app\controller;

use app\model\Controller;
use app\model\Utils;
use app\model\Session;
use app\model\UserUtils;
use app\model\PostDAO;

class PostList extends Controller
{
    public function MethodGet() : void
    {
        $session = new Session($this);
        $session->RedirectNoAdmin();
        $session->ShowAllAlertAndClear();

        $userUtils = new UserUtils();
        $userUtils->EnableAlert_Direct($this);

        $postDAO = new PostDAO();
        $postDAO->SetUtils($userUtils);

        $get = $this->PrepareGet(['pn']);
        $pn = is_numeric($get->pn) && $get->pn > 0 ? (int)$get->pn : 1;
        $this->TemplateAddContext('pn', $pn);

        $this->TemplateAddContext('posts', $postDAO->ReadList(--$pn*10));
    }
}

?>