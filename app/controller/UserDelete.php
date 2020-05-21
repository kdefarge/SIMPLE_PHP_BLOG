<?php

namespace app\controller;

use app\model\Controller;
use app\model\Utils;
use app\model\Session;
use app\model\UserUtils;
use app\model\UserDAO;

class UserDelete extends Controller
{
    protected function MethodPost() : void
    {
        $session =  new Session($this);
        $session->ClearAlert();
        $session->RedirectGuest();
        
        $userUtils = new UserUtils();
        $userUtils->EnableAlert_Redirect($session);

        $userDAO = new UserDAO();
        $userDAO->SetUtils($userUtils);

        $user = $session->GetUserLogged();

        $post = $this->PreparePost(['userid']);
        $userid = (int)$post->userid;
        
        if($user->GetID() == $userid)
        {
            $session->SetUserLogged(null);
            $userDAO->Delete($user->GetID());
            $userUtils->AddInfo('Votre compte est supprimé et vous êtes déconnecté');
            $this->redirect();
        }
        else
        {
            if($user->GetIsAdmin())
            {
                $userDAO->Delete($userid);
                $userUtils->AddError('Utilisateur supprimé');
                $this->redirect('userlist');
            }
            else
            {
                $userUtils->AddError('Vous ne pouvez pas faire cela');
                $this->redirect();
            }
        }
    }

    public function MethodGet() : void
    {
        $session = new Session($this);
        $session->RedirectGuest();
        
        $get = $this->PrepareGet(['id']);
        if(!is_numeric($get->id))
            $this->Redirect();
        
        $this->TemplateAddContext('userid',$get->id);
    }
}

?>