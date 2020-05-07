<?php

namespace app\model;

abstract class Controller
{
    const TEMPLATE_DIR = 'app/templates';

    private $_post = null;
    private $_alerts = [];
    private ?User $_userLogged = null;
    private $_templateContext = [];

    abstract protected function MethodGet() : void;

    protected function MethodPost() : void
    {
        $this->Redirect();
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

            $context['post'] = $this->_post;
        }
        else
        {            
            $context = $this->MethodGet();
        }

        $this->Template($controllerName);
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
        $this->TemplateAddContext('post', $this->_post);
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

    public function TemplateAddContext(string $key, $value) : void
    {
        $this->_templateContext[$key] = $value;
    }

    private function Template(string $name) : void
    {
        $loader = new \Twig\Loader\FilesystemLoader(self::TEMPLATE_DIR);

        $twig = new \Twig\Environment($loader, [
            'debug' => true,
            'cache' => 'app/cache'
        ]);
        
        $context = $this->_templateContext;
        if(!is_null($this->_userLogged))
            $context['userLogged'] = $this->_userLogged;
        if(count($this->_alerts))
           $context['alerts'] = $this->_alerts;
        
        echo $twig->render($name.'.html', $context);
    }

    public function Die(?Alert $alert = null) : void
    {
        if(!is_null($alert))
            $this->_alerts[] = $alert;
        $this->Template('base', ['alerts' => $this->_alerts]);
        die();
    }

    public function Redirect(string $page = 'home') : void
    {
        header('Location: index.php?page='.$page);
        $alert = new Alert(
            'Vous êtes redirigez sur <a href=" index.php?page='.$page.'"> CETTE PAGE </a>',
             Alert::TYPE_INFO
            );
        $this->Die($alert);
    }

    public function SetUserLogged(User $user) : void
    {
        $this->_userLogged = $user;
    }
}

?>