<?php

/**
 * load composer dependency :
 * - Twig v3.0.3
 */

require_once "vendor/autoload.php";

$CONFIGS = include('config.php');

$routing = [
    'admin' => 'Routing',
    'register' => 'Register',
    'login' => 'Login',
    'logout' => 'Logout',
    'userlist' => 'UserList',
    'useredit' => 'UserEdit',
    'userdelete' => 'UserDelete',
    'account' => 'Account',
    'postcreate' => 'PostCreate',
    'postedit' => 'PostEdit',
    'postlist' => 'PostList',
    'postdelete' => 'PostDelete',
    'postread' => 'PostRead',
    'commentvalid' => 'CommentValid',
    'commentdelete' => 'CommentDelete',
    'contact' => 'Contact',
    'generator' => 'Generator'
];

session_start();

new app\model\Router($routing, 'Home');

?>