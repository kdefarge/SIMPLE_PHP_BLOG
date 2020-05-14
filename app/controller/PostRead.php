<?php

namespace app\controller;

use app\model\Controller;
use app\model\Utils;
use app\model\Session;
use app\model\PostDAO;
use DateTime;

class PostRead extends Controller
{
    public function MethodGet() : void
    {
        $session = new Session($this);

        $utils = new Utils();
        $utils->EnableAlert_Redirect($session);

        $postDAO = new PostDAO();
        $postDAO->SetUtils($utils);

        $get = $this->PrepareGet(['id']);
        $post = $postDAO->ReadByID($get->id);

        if(is_null($post))
        {
            $utils->AddError('Cette article n\'existe pas');
            $this->Redirect('home');
        }

        if(is_null($post->GetPublish()) || $post->GetPublish() > new DateTime("now"))
        {
            $utils->AddError('Cette article n\'est pas accessible');
            $this->Redirect('home');
        }

        $this->TemplateAddContext('post', $post);
    }
}

?>