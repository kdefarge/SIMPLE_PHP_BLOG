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

app\model\Controller::Run($routing, 'Home');

?>