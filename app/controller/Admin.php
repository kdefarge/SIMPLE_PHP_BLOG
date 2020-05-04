<?php

namespace app\controller;

use app\model\Controller;

class Admin extends Controller
{
    public function MethodPost($post)
    {

    }

    public function MethodGet($get)
    {
        $this->Template("admin");
    }
}

?>