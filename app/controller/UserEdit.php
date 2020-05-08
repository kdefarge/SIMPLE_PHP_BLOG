<?php

namespace app\controller;

use app\model\Controller;
use app\model\Utils;
use app\model\Session;
use app\model\UserUtils;
use app\model\UserDAO;

class UserEdit extends Controller
{
    protected function MethodPost() : void
    {
        $session =  new Session($this);
        $session->RedirectNoAdmin();
        $session->ClearAlert();
        
        $userUtils = new UserUtils();
        $userUtils->EnableAlert_Redirect($session);

        $userDAO = new UserDAO();
        $userDAO->SetUtils($userUtils);

        $post = $this->PreparePost(['userid', 'name', 'password', 'admin']);

        $user = is_numeric($post->userid)?$userDAO->ReadByID($post->userid):null;

        if(is_null($user))
        {
            $userUtils->AddError('Cette utilisateur n\'existe pas');
            $this->Redirect('userlist');
        }
        
        $formValidate = false;

        if(!empty($post->password))
        {
            if($userUtils->PasswordValid($post->password))
            {
                $user->SetPassword($userUtils->PasswordHash($post->password));
                $formValidate = true;
                $userUtils->AddValide('Le nouveau mot de passe est sauvegardé');
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

        $admin = $post->admin=='1'?true:false;
        if($admin != $user->GetIsAdmin())
        {
            $user->SetIsAdmin($admin);
            $formValidate = true;
            if($admin)
                $userUtils->AddValide('Est maintenant admin');
            else
                $userUtils->AddValide('N\'est plus admin');
        }
        
        if($formValidate)
        {
            $userDAO->Update($user);
        }
        else
        {
            $userUtils->AddInfo('Acune modification');
        }
        
        $this->redirect('useredit&id='.$post->userid);
    }

    public function MethodGet() : void
    {
        $session = new Session($this);
        $session->RedirectNoAdmin();
        $session->ShowAllAlertAndClear();

        $userUtils = new UserUtils();
        $userUtils->EnableAlert_Direct($this);

        $userDAO = new UserDAO();
        $userDAO->SetUtils($userUtils);

        $get = $this->PrepareGet(['id']);
        $user = $userDAO->ReadByID($get->id);

        if(!is_null($user))
            $this->TemplateAddContext('user', $user);
    }
}

?>