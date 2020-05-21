<?php

namespace app\controller;

use app\model\Controller;
use app\model\Utils;
use app\model\Session;
use app\model\PostDAO;
use app\model\CommentDAO;
use app\model\UserDAO;
use app\model\Comment;
use app\model\Post;
use DateTime;

class PostRead extends Controller
{
    protected function MethodPost() : void
    {
        $p = $this->PreparePost(['postid', 'text']);
        $_GET['id'] =  $p->postid;

        $utils = new Utils();
        $utils->EnableAlert_Direct($this);

        if(!$utils->NotBlank('text', $p->text))
        {
            $this->MethodGet();
            return;
        }
        
        if(!$utils->MinLength('text', $p->text, 3))
        {
            $this->MethodGet();
            return;
        }
            
        if(!$utils->MaxLength('text', $p->text, 1000))
        {
            $this->MethodGet();
            return;
        }

        $session =  new Session($this);
        $session->ClearAlert();
        $session->RedirectGuest();
        $utils->EnableAlert_Redirect($session);
        
        $userDAO = new UserDAO();
        $userDAO->SetUtils($utils);

        $user = $userDAO->ReadByID($session->GetUserLogged()->GetID());
        
        if($user === null)
        {
            $session->SetUserLogged(null);
            $utils->AddError('Compte supprimé');
            $utils->AddInfo('Votre session a expiré');
            $this->Redirect();
        }

        $postDAO = new PostDAO();
        $postDAO->SetUtils($utils);

        $post = is_numeric($p->postid)?$postDAO->ReadByID($p->postid):null;

        if($post === null)
        {
            $utils->AddError('Cette article n\'existe pas');
            $this->Redirect();
        }

        $comment = new Comment();
        $comment->SetUser($user);
        $comment->SetPost($post);
        $comment->SetText($p->text);
        if($user->GetIsAdmin())
        {
            $comment->SetIsValid(true);
            $utils->AddInfo('Vous êtes admin !');
            $utils->AddValide('Votre commentaire est rajouté !');
        }
        else
            $utils->AddValide('Votre commentaire est en attente de validation !');

        $commentDAO = new CommentDAO();
        $commentDAO->SetUtils($utils);
        $commentDAO->Create($comment);

        $this->redirect('postread&id='.$p->postid.'#comment_section');
    }

    public function MethodGet() : void
    {
        $session = new Session($this);
        $session->ShowAllAlertAndClear();

        $utils = new Utils();
        $utils->EnableAlert_Redirect($session);

        $postDAO = new PostDAO();
        $postDAO->SetUtils($utils);

        $get = $this->PrepareGet(['id']);
        if(!is_numeric($get->id))
            $this->Redirect('home');

        $post = $postDAO->ReadByID($get->id);

        if($post === null)
        {
            $utils->AddError('Cette article n\'existe pas');
            $this->Redirect('home');
        }

        if($post->GetPublish() === null || $post->GetPublish() > new DateTime("now"))
        {
            $utils->AddError('Cette article n\'est pas accessible');
            $this->Redirect('home');
        }

        $commentDAO = new CommentDAO();
        $commentDAO->SetUtils($utils);

        $comments = $commentDAO->ReadList($post->GetID());

        $this->TemplateAddContext('post', $post);
        $this->TemplateAddContext('comments', $comments);
    }
}

?>