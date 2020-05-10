<?php

namespace app\controller;

use app\model\Controller;
use app\model\Utils;
use app\model\Session;
use app\model\UserUtils;
use app\model\UserDAO;

class Account extends Controller
{
    protected function MethodPost() : void
    {
        $session =  new Session($this);
        $session->RedirectGuest();
        $session->ClearAlert();
        
        $userUtils = new UserUtils();
        $userUtils->EnableAlert_Redirect($session);

        $userDAO = new UserDAO();
        $userDAO->SetUtils($userUtils);

        $post = $this->PreparePost(['name', 'password', 'passwordCheck']);
        
        $formValidate = false;
        $user = $session->GetUserLogged();

        if(!empty($post->password))
        {
            if($userUtils->PasswordValid($post->password))
            {   
                if($post->password == $post->passwordCheck)
                {
                    $user->SetPassword($userUtils->PasswordHash($post->password));
                    $formValidate = true;
                    $userUtils->AddValide('Le nouveau mot de passe est sauvegardé');
                }
                else
                {
                    $userUtils->AddError('La vérfication du mot de passe doit être identique au mot de passe');
                }
            }
        }

        if($userUtils->UserNameValid($post->name))
        {
            if($user->GetName() != $post->name)
            {
                if(is_null($userDAO->ReadByName($post->name)))
                {
                    $user->SetName($post->name);
                    $formValidate = true;
                    $userUtils->AddValide('Le nouveau nom d\'utilisateur est sauvegardé');
                }
                else
                {
                    $userUtils->AddError('Ce nom d\'utilisateur est déjà pris');
                }
            }
        }
        
        if($formValidate)
        {
            $userDAO->Update($user);
            $session->SetUserLogged($user);
        }
        else
        {
            $userUtils->AddInfo('Acune modification');
        }
        
        $this->redirect('account');
    }

    public function MethodGet() : void
    {
        $session = new Session($this);
        $session->RedirectGuest();
        $session->ShowAllAlertAndClear();
    }
}

?>