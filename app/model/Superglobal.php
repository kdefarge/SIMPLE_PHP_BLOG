<?php

namespace app\model;

class Superglobal
{
    public function get_string_sanitize_deep(string $key) : ?string
    {
        $value = filter_input(INPUT_GET, $key, FILTER_SANITIZE_STRING, 
            FILTER_FLAG_EMPTY_STRING_NULL | FILTER_FLAG_STRIP_LOW | 
            FILTER_FLAG_STRIP_HIGH | FILTER_FLAG_STRIP_BACKTICK);
        if($value === false)
            return null;
        return $value;
    }

    public function get_string_sanitize(string $key) : ?string
    {
        $value = filter_input(INPUT_GET, $key, FILTER_SANITIZE_STRING, 
            FILTER_FLAG_EMPTY_STRING_NULL | FILTER_FLAG_STRIP_LOW);
        if($value === false)
            return null;
        return $value;
    }
}

?>