<?php

namespace app\model;

class Router
{
    function __construct(array $routing, string $default)
    {
        $controllerName = $default;
        
        $core = new Core();

        $pageName = $core->get_superglobal()->get_string_sanitize_deep('page');

        if($pageName !== null) {
            $pageName = strtolower($pageName);
            if(array_key_exists($pageName, $routing))
                $controllerName = $routing[$pageName];
        }
        
        $class = "\\app\\controller\\$controllerName";

        $controller = new $class();

        $core->set_controller($controller);

        $controller->set_core($core);
        $controller->Running($controllerName);
    }
}

?>