<?php

namespace app\model;

abstract class Controller
{
    const TEMPLATE_DIR = 'app/templates';

    private $_post = null;
    private $_alerts = [];

    abstract protected function MethodGet() : void;

    protected function MethodPost() : void
    {
        header('Location: index.php');
    }

    public static function Run(array $controllerValid, string $default) : void
    {
        if(isset($_GET['page']))
        {
            $controllerName = ucfirst(strtolower($_GET['page']));
            if(!in_array($controllerName, $controllerValid))
                $controllerName = $default;
        }
        else
        {
            $controllerName = $default;
        }

        $class = "\\app\\controller\\$controllerName";
        (new $class())->Running($controllerName);
    }

    public function Running(string $controllerName) : void
    {
        $context = null;

        if(count($_POST) > 0)
        {
            $context = $this->MethodPost();

            $context = is_array($context)?$context:[];

            $context['post'] = $this->_post;
        }
        else
        {            
            $context = $this->MethodGet();
            
            $context = is_array($context)?$context:[];
        }

        $context['alerts'] = $this->_alerts;

        $this->Template($controllerName, $context);
    }

    private function PrepareObject(array $keys, array $array) : object
    {
        $obj = (object)[];
        foreach($keys AS $key)
        {
            $obj->$key = isset($array[$key])?$array[$key]:'';
        }
        return $obj;
    }

    protected function PreparePost(array $keys) : object
    {
        $this->_post = $this->PrepareObject($keys, $_POST);
        return $this->_post;
    }

    protected function PrepareGet(array $keys) : object
    {
        return $this->PrepareObject($keys, $_GET);
    }

    public function AddAlert(Alert $alert) : void
    {
        $this->_alerts[] = $alert;
    }

    private function Template(string $name, array $context = []) : void
    {
        $loader = new \Twig\Loader\FilesystemLoader(self::TEMPLATE_DIR);

        $twig = new \Twig\Environment($loader, [
            'debug' => true,
            'cache' => 'app/cache'
        ]);
        
        echo $twig->render($name.'.html', $context);
    }

    public function Die() : void
    {
        $this->Template('base', ['alerts' => $this->_alerts]);
        die();
    }

    protected function Redirect(string $page) : void
    {
        header('Location: index.php?page='.$page);
    }
}

?>