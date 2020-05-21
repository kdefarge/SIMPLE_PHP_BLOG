<?php

namespace app\model;

class Superglobal
{
    public static function get_string_sanitize(string $key) : ?string
    {
        if(!isset($_GET[$key]))
            return null;
        
        return filter_var($_GET[$key], FILTER_SANITIZE_STRING, FILTER_FLAG_EMPTY_STRING_NULL);
    }

    public static function post_string_sanitize($key) : ?string
    {
        if(!isset($_POST[$key]))
            return null;
    
        return filter_var($_POST[$key], FILTER_SANITIZE_STRING, FILTER_FLAG_EMPTY_STRING_NULL);
    }
}

?>