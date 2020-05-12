<?php

namespace app\controller;

use app\model\Controller;
use app\model\User;
use app\model\Post;
use app\model\UserDAO;
use app\model\PostDAO;
use app\model\Alert;
use app\model\Utils;
use app\model\Session;

class PostCreate extends Controller
{
    protected function MethodPost() : void
    {
        $this->TemplateSetName('post_create');

        $session =  new Session($this);
        $session->ClearAlert();
        $session->RedirectNoAdmin();

        $p = $this->PreparePost(['title', 'authorid', 'publish', 'header', 'content']);
        
        $utils = new Utils();
        $utils->EnableAlert_Direct($this);

        if(!$utils->NotBlank('titre', $p->title))
            return;

        $postDAO = new PostDAO();
        $postDAO->SetUtils($utils);
        
        if(is_numeric($p->authorid))
        {
            $user = new User();
            $user->SetID((int)$p->authorid);
        }
        else
            $user = null;

        $post = new Post();
        $post->SetTitle($p->title);
        $post->SetUser($user);
        $post->SetPublishString($p->publish);
        $post->SetHeader($p->header);
        $post->SetContent($p->content);

        $postDAO->Create($post);
        $utils->EnableAlert_Redirect($session);
        $utils->AddValide('Votre nouvelle article est sauvegardé !');
        $this->redirect('postlist');
    }

    protected function MethodGet() : void
    {
        $session = new Session($this);
        $session->RedirectNoAdmin();
        $session->ShowAllAlertAndClear();
        
        $userUtils = new UserUtils();
        $userUtils->EnableAlert_Direct($this);
        
        $userDAO = new UserDAO();
        $userDAO->SetUtils($userUtils);

        $this->TemplateAddContext('admins', $userDAO->ReadAdminList());
        $this->TemplateSetName('post_create');
    }
}

?>