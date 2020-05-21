<?php

namespace app\model;

class Superglobal
{
    public array $session;
    public array $get;
    public array $post;

    public function __construct() {
        $this->session = &$_SESSION;
        $this->get = &$_GET;
        $this->post = &$_POST;
    }

    public function get_string_sanitize(string $key) : ?string
    {
        if(!isset($this->get[$key]))
            return null;
        
        return filter_var($this->get[$key], FILTER_SANITIZE_STRING, FILTER_FLAG_EMPTY_STRING_NULL);
    }

    public function post_string_sanitize($key) : ?string
    {
        if(!isset($this->post[$key]))
            return null;
    
        return filter_var($this->post[$key], FILTER_SANITIZE_STRING, FILTER_FLAG_EMPTY_STRING_NULL);
    }
}

?>