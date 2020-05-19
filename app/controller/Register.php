<?php

namespace app\controller;

use app\model\Controller;
use app\model\User;
use app\model\UserDAO;
use app\model\Alert;
use app\model\UserUtils;
use app\model\Session;

class Register extends Controller
{
    protected function MethodPost() : void
    {
        $session =  new Session($this);
        $session->ClearAlert();
        $session->RedirectConnected();

        $post = $this->PreparePost(['name', 'password', 'passwordCheck']);

        $formValidate = true;
        
        $userUtils = new UserUtils();
        $userUtils->EnableAlert_Direct($this);

        $userDAO = new UserDAO();
        $userDAO->SetUtils($userUtils);

        if(!$userUtils->PasswordValid($post->password))
            $formValidate = false;
        
        if($post->password != $post->passwordCheck)
        {
            $formValidate = false;
            $userUtils->AddError('La vérfication du mot de passe doit être identique au mot de passe');
        }

        if($userUtils->UserNameValid($post->name))
        {
            if($userDAO->ReadByName($post->name))
            {
                $formValidate = false;
                $userUtils->AddError('Ce nom d\'utilisateur est déjà pris');
            }
        }
        else
            $formValidate = false;
        
        if($formValidate)
        {
            $user = new User();
            $user->SetName($post->name);
            $user->SetPassword($userUtils->PasswordHash($post->password));

            $userDAO->Create($user);
            $userUtils->EnableAlert_Redirect($session);
            $userUtils->AddValide('Vous êtes maintenant enregistré !');
            $this->redirect('home');
        }
    }

    protected function MethodGet() : void
    {
        $session = new Session($this);
        $session->RedirectConnected();
        $session->ShowAllAlertAndClear();
    }
}

?>