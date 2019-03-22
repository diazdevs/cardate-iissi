<?php

// namespace core;

require_once 'router.php';

class App {

    function __construct(){

        /**
         * cstf_token
         * - https://stackoverflow.com/questions/5207160/what-is-a-csrf-token-what-is-its-importance-and-how-does-it-work
         * - implementation: https://stackoverflow.com/questions/6287903/how-to-properly-add-csrf-token-using-ph
         */ 

        if (empty($_SESSION['token'])) {
            if (function_exists('mcrypt_create_iv')) {
                $_SESSION['token'] = bin2hex(mcrypt_create_iv(32, MCRYPT_DEV_URANDOM));
            } else {
                $_SESSION['token'] = bin2hex(openssl_random_pseudo_bytes(32));
            }
        }

        $url = isset($_GET['url']) ? $_GET['url']: null;
        $route = new Router($url);
        
    }

}