<?php

namespace app\controller;

use app\model\Controller;

class Home extends Controller
{
    public function MethodPost($post)
    {
        
    }

    public function MethodGet($get)
    {
        $this->Template("home");
    }
}

?>