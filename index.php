<?php

/**
 * load composer dependency :
 * - Bootstrap v4.4.1
 * - Twig v3.0.3
 */

require "vendor/autoload.php";

define("DEV", true);

$loader = new \Twig\Loader\FilesystemLoader('app/templates');

$twig = new \Twig\Environment($loader, [
    'debug' => DEV,
    'cache' => 'app/cache'
]);

if(isset($_GET['page']))
{
    switch($_GET['page']) {
        case "admin" :
            echo $twig->render('admin.html');
            break;
        default:
            echo $twig->render('home.html');
    }
}
else
{
    echo $twig->render('home.html');
}

?>