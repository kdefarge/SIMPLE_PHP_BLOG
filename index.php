<?php

/**
 * load composer dependency :
 * - Bootstrap v4.4.1
 * - Twig v3.0.3
 */

require "vendor/autoload.php";

session_start();
app\model\Controller::Run(['Admin', 'Register'],'Home');

?>