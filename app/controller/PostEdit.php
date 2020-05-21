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

class PostEdit extends Controller
{
    protected function MethodPost() : void
    {
        $session =  new Session($this);
        $session->ClearAlert();
        $session->RedirectNoAdmin();

        $p = $this->PreparePost(['postid', 'title', 'authorid', 'publish', 'header', 'content']);
        
        $utils = new Utils();
        $utils->EnableAlert_Redirect($session);

        $postDAO = new PostDAO();
        $postDAO->SetUtils($utils);
        
        $post = is_numeric($p->postid)?$postDAO->ReadByID($p->postid):null;

        if($post === null)
        {
            $utils->AddError('Cette article n\'existe pas');
            $this->Redirect('postlist');
        }

        if(is_numeric($p->authorid))
        {
            $user = new User();
            $user->SetID((int)$p->authorid);
        }
        else
            $user = null;

        if($utils->NotBlank('titre', $p->title))
            $post->SetTitle($p->title);
        else
            $utils->AddInfo('Ancien titre restauré !');
        $post->SetUser($user);
        if(empty($p->publish))
            $post->SetPublish(null);
        else
            $post->SetPublishString($p->publish);
        $post->SetHeader($p->header);
        $post->SetContent($p->content);

        $postDAO->Update($post);
        $utils->AddValide('Votre nouvel article est sauvegardé !');
        $this->redirect('postedit&id='.$p->postid);
    }

    protected function MethodGet() : void
    {
        $session = new Session($this);
        $session->RedirectNoAdmin();
        $session->ShowAllAlertAndClear();
        
        $utils = new Utils();
        
        $userDAO = new UserDAO();
        $userDAO->SetUtils($utils);

        $postDAO = new PostDAO();
        $postDAO->SetUtils($utils);

        $get = $this->PrepareGet(['id']);
        $post = $postDAO->ReadByID($get->id);

        if($post === null)
        {
            $utils->EnableAlert_Redirect($session);
            $utils->AddError('Cette article n\'existe pas');
            $this->Redirect('postlist');
        }
        
        $this->TemplateAddContext('p', $post);
        $this->TemplateAddContext('admins', $userDAO->ReadAdminList());
    }
}

?>