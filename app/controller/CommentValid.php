<?php

namespace app\controller;

use app\model\Controller;
use app\model\Utils;
use app\model\Session;
use app\model\CommentDAO;

class CommentValid extends Controller
{
    public function MethodGet() : void
    {
        $session = new Session($this);
        $session->RedirectNoAdmin();

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

        $commentDAO->UpdateValid($comment->GetID(), true);

        $utils->AddInfo('Commentaire validé');
        $this->Redirect('postread&id='.$comment->GetPost()->GetID());
    }
}

?>