<?php

namespace app\model;

abstract class Controller
{
    const TEMPLATE_DIR = 'app/templates';

    abstract protected function MethodPost($post);

    abstract protected function MethodGet($get);

    public static function Run($controllerValid, $default)
    {
        $controllerName = ucfirst(strtolower($_GET['page']));
        
        if(!in_array($controllerName, $controllerValid))
            $controllerName = $default;

        $class = "\\app\\controller\\$controllerName";
        (new $class())->Running();
    }

    public function Running()
    {
        if(count($_POST) > 0)
        {
            $this->MethodPost($_POST);
        }
        else
        {
            $this->MethodGet($_GET);
        }
    }

    protected function Template($name, $context = null)
    {
        $loader = new \Twig\Loader\FilesystemLoader(self::TEMPLATE_DIR);

        $twig = new \Twig\Environment($loader, [
            'debug' => true,
            'cache' => 'app/cache'
        ]);
        
        echo $twig->render($name.'.html', is_null($context)?[]:$context);
    }
}

?>