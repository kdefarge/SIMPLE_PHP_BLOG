<?php

namespace app\model;

abstract class Controller
{
    const TEMPLATE_DIR = 'app/templates';

    private array $_alerts = [];
    private ?User $_userLogged = null;
    private ?string $_templateName = null;
    private array $_templateContext = [];

    private Core $core;

    public function set_core(Core $core) : void
    {
        $this->core = $core;
    }

    public function get_core() : Core
    {
        return $this->core;
    }

    abstract protected function MethodGet() : void;

    protected function MethodPost() : void
    {
        $this->Redirect();
    }

    public function Running(string $controllerName) : void
    {
        if(count($_POST) > 0)
        {
            $this->MethodPost();
        }
        else
        {            
            $this->MethodGet();
        }

        $this->_templateName = $this->_templateName === null?
            $controllerName:$this->_templateName;
            
        $this->Template($this->_templateName);
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
        $post = $this->PrepareObject($keys, $_POST);
        $this->TemplateAddContext('m_post', $post);
        return $post;
    }

    protected function PrepareGet(array $keys) : object
    {
        return $this->PrepareObject($keys, $_GET);
    }

    public function AddAlert(Alert $alert) : void
    {
        $this->_alerts[] = $alert;
    }

    public function TemplateSetName(string $name)
    {
        $this->_templateName = $name;
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

        if(!isset($context['pagename']))
            $context['pagename'] = $this->_templateName;

        if($this->_userLogged !== null)
            $context['userLogged'] = $this->_userLogged;

        if(count($this->_alerts) > 0)
            $context['alerts'] = $this->_alerts;
        
        echo $twig->render($name.'.html', $context);
    }

    public function Die(?Alert $alert = null) : void
    {
        if($alert !== null)
            $this->_alerts[] = $alert;
        $this->Template('base', ['alerts' => $this->_alerts]);
        die();
    }

    public function Redirect(string $page = 'home') : void
    {
        header('Location: index.php?page='.$page);
        die('redirection vers => <a href="index.php?page='.$page.'">index.php?page='.$page.'</a>');
    }

    public function SetUserLogged(?User $user) : void
    {
        $this->_userLogged = $user;
    }
}

?>