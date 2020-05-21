<?php

namespace app\model;

class Router
{
    function __construct(array $routing, string $default)
    {
        $controllerName = $default;
        
        $superglobal = new Superglobal();

        $pageName = $superglobal->get_string_sanitize_deep('page');

        if($pageName !== null) {
            $pageName = strtolower($pageName);
            if(array_key_exists($pageName, $routing))
                $controllerName = $routing[$pageName];
        }
        
        $class = "\\app\\controller\\$controllerName";
        (new $class())->Running($controllerName);
    }
}

?>