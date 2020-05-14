<?php

namespace app\controller;

use app\model\Controller;
use app\model\Utils;
use app\model\Session;
use app\model\CommentDAO;

class CommentDelete extends Controller
{
    public function MethodGet() : void
    {
        $session = new Session($this);
        $session->RedirectGuest();

        $utils = new Utils();
        $utils->EnableAlert_Redirect($session);

        $get = $this->PrepareGet(['id']);
        if(!is_numeric($get->id))
            $this->Redirect('home');

        $commentDAO = new CommentDAO();
        $commentDAO->SetUtils($utils);
        $comment = $commentDAO->ReadByID($get->id);

        if(is_null($comment))
        {
            $utils->AddError('Ce commentaire est introuvable');
            $this->Redirect('home');
        }

        $user = $session->GetUserLogged();
        if($user->GetIsAdmin())
        {
            $commentDAO->Delete($comment->GetID());
        }
        else
        {
            if($comment->GetUser()->GetID() != $user->GetID())
            {
                $utils->AddError('Vous ne pouvez faire ça !');
                $this->Redirect('postread&id='.$comment->GetPost()->GetID());
            }
            $commentDAO->Delete($comment->GetID());
        }

        $utils->AddValide('Commentaire supprimé !');
        $this->Redirect('postread&id='.$comment->GetPost()->GetID());
    }
}

?>