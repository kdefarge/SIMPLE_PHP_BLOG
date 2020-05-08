<?php

/**
 * load composer dependency :
 * - Bootstrap v4.4.1
 * - Twig v3.0.3
 */

require "vendor/autoload.php";

$routing = [
    'admin' => 'Routing',
    'register' => 'Register',
    'login' => 'Login',
    'logout' => 'Logout',
    'userlist' => 'UserList',
    'useredit' => 'UserEdit'
];

app\model\Controller::Run($routing, 'Home');

?>