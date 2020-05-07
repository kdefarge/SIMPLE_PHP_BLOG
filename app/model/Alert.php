<?php

namespace app\model;

class Alert 
{
    private const TYPES = [
        'primary',
        'seconday',
        'success',
        'danger',
        'warning',
        'info',
        'light',
        'dark'
    ];

    const TYPE_PRIMARY = 0;
    const TYPE_SECONDARY = 1;
    const TYPE_SUCCESS = 2;
    const TYPE_DANGER = 3;
    const TYPE_WARNING = 4;
    const TYPE_INFO = 5;
    const TYPE_LIGT = 6;
    const TYPE_DARK = 7;

    public $title;
    public $text;
    public $type;

    function __construct($text, $type = self::TYPE_DANGER)
    {
        $this->title = '';
        $this->text = $text;
        $this->type = self::TYPES[$type];
    }
}