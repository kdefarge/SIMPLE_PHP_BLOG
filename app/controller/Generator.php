<?php

namespace app\controller;

use app\model\Controller;
use app\model\UserUtils;
use app\model\UserDao;
use app\model\User;

class Generator extends Controller
{
    public function MethodGet() : void
    {
        $userUtils = new UserUtils();
        $userUtils->EnableAlert_Direct($this);

        $userDAO = new UserDAO();
        $userDAO->SetUtils($userUtils);

        $user = new User();
        $user->SetPassword($userUtils->PasswordHash(''));
        
        for($i=1;$i<=200;$i++)
        {
            $user->SetName('User_V3_n'.$i);
            $userDAO->Create($user);
        }

        $userUtils->AddValide('Génération terminé');
        $this->TemplateSetName('Home');
    }
}

?>