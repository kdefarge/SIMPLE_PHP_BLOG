<?php

namespace app\controller;

use app\model\Controller;
use app\model\Utils;
use app\model\Session;
use app\model\PostDAO;

class PostDelete extends Controller
{
    protected function MethodPost() : void
    {
        $session =  new Session($this);
        $session->ClearAlert();
        $session->RedirectNoAdmin();
        
        $utils = new Utils();
        $utils->EnableAlert_Redirect($session);

        $postDAO = new PostDAO();
        $postDAO->SetUtils($utils);

        $post = $this->PreparePost(['postid']);
        $postid = (int)$post->postid;
        $postDAO->Delete($postid);

        $utils->AddInfo('Article supprimé');
        $this->redirect('postlist');
    }

    public function MethodGet() : void
    {
        $session = new Session($this);
        $session->RedirectNoAdmin();
        
        $get = $this->PrepareGet(['id']);
        if(!is_numeric($get->id))
            $this->Redirect();
        
        $this->TemplateAddContext('postid',$get->id);
    }
}

?>