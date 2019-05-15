<?php


// Template engine
require_once 'vendor/autoload.php';

class Controller {
    private $model;
    private $availableMethods = ['GET', 'POST'];


    public function __construct(){
        // Check if request method is in available methods
        if (!in_array($_SERVER['REQUEST_METHOD'], $this->availableMethods))
            $this->http500();

        // Check csrf_token is received if request method is post
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && !isset($_POST['token']) && $_POST['token'] == $_SESSION['token'])    
            $this->http500();
    }


    public function isPost(){
        return $_SERVER['REQUEST_METHOD'] === 'POST';
    }

    public function isGet(){
        return $_SERVER['REQUEST_METHOD'] === 'GET';
    }

    public function isAjax(){
        // https://paulund.co.uk/use-php-to-detect-an-ajax-request
        return !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
    }


    /**
     * Twig template render
     * @todo move to View core class
     */
    public function render($template, $ctx=[]){
        $loader = new \Twig\Loader\FilesystemLoader('app/views');
        $twig = new \Twig\Environment($loader);
        // Add CSRF token to context
        $ctx['token'] = $_SESSION['token'];
        echo $twig->render($template, $ctx);
    }

    // 400 Bad Request1
    public function http400($extra=false){
        http_response_code(400);
        $this->render('errors/400.html');
        die();
    }

    // 404 Not Found
    public function http404($extra=false){
        http_response_code(404);
        $this->render('errors/404.html');
        die();
    }

    // 500 Internal Server Error
    public function http500($extra=false){
        http_response_code(500);
        $this->render('errors/500.html');
        die();
    }

    // Redirect
    public function redirect($url, $extra=false){
        Header('Location: ' . $url);
    }


    /**
     * Check if user must be logged or not and redirect if needed.
     */
    public function checkAuth($redirect_url='/', $logged=true){

        // Si el usuario debe estar logueado y no lo esta redirigimos
        if ($logged && !isset($_SESSION['email_usuario']))
            $this->redirect($redirect_url);
        
        // Si el usuario no debe estar logueado y lo esta redirigimos
        if (!$logged && isset($_SESSION['email_usuario']))
            $this->redirect($redirect_url);

    }
    
}



