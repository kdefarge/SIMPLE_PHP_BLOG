<?php

namespace app\controller;

use app\model\Controller;
use app\model\UserDAO;
use app\model\UserUtils;
use app\model\Session;
use app\model\Alert;

class Login extends Controller
{
    public function MethodPost() : void
    {
        $session = new Session($this);
        $session->RedirectConnected();

        $post = $this->PreparePost(['name', 'password']);

        $userUtils = new UserUtils();
        
        if($userUtils->UserNameValid($post->name))
        {
            $userDAO = new UserDAO();
            $userDAO->SetUtils($userUtils);

            $user = $userDAO->ReadByName($post->name);
            if($user !== null)
            {
                if($userUtils->UserPasswordVerify($user, $post->password))
                {
                    $session->SetUserLogged($user);
                    $userUtils->EnableAlert_Redirect($session);
                    $userUtils->AddValide('Vous êtes maintenant connecté !');
                    $this->Redirect('home');
                }
            }
        }

        $userUtils->EnableAlert_Direct($this);
        $userUtils->AddError('Erreur identification');
    }

    public function MethodGet() : void
    {
        $session = new Session($this);
        $session->RedirectConnected();
        $session->ShowAllAlertAndClear();
    }
}

?>