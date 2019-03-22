<?php

/**
 * Check if url pattern contains a variable,
 * ergo, starts and ends with "<", ">" 
 * <variableName:regexLike>
 */
function isVariable($param){
    return (substr($param, 0, 1) === '<') &&
        (substr($param, -1) === '>');
}



/**
 * config/urls.php dispatcher
 */
class Router {
    
    private $requests;
    private $urls;

    public function __construct($request) {
        // vamos a transformar las urls
        global $router_urls;
        $this->urls = array_map(function($obj){
            return [
                'url' => explode('/', $obj[0]),
                'method' => $obj[1]];
            }, $router_urls);

        $matchPath = $this->parser($request);


        if ($matchPath !== null) {
            // Si la url pedida esta en la lista de enrutamiendo ejecutamos el controlador
            $method = explode('->', $matchPath['method']);
            if (count($method) != 2){
                echo 'Error en la configuracion de urls';
            } else {
                $this->loadController($method[0], $method[1], $matchPath['params']);
            }
        } else {
            // Redirect to 404 view
            header('Location: ' . constant('HTTP404')); 
        }

    }

    public function parser($request) {
        $urls = $this->urls;
        $request = explode('/', rtrim($request, '/'));
        $methodParams = [];
        foreach ($urls as $url){
            $path = $url['url'];

            if (count($path) == count($request)) {
                $i = 0;
                $matched = True;
                while ($i < count($path)) {

                    $param = $path[$i];
                    if (isVariable($param)) {

                        $param = substr($param, 1, -1);
                        $regexLike = explode(':', $param);

                        if (count($regexLike) == 2){

                            $pattern = $regexLike[1];
                            if (!preg_match("/$pattern/", $request[$i])){
                                $matched = False;
                                break;
                            }
                        }
                        $methodParams[$param] = $request[$i];

                    } else {

                        if ($param != $request[$i]){
                            $matched = False;
                            break;
                        }
                    }

                    $i++;
                }

                if ($matched) {
                    return [
                        'method'=>$url['method'],
                        'params'=>$methodParams
                    ];
                } else {
                    // vaciamos el array
                    $methodParams = [];
                }
            }
        }

        return null;

    }


    function loadController($controller, $method, $methodParams){
        $pathToController = "app/controllers/$controller.php";
        if (file_exists($pathToController)){
            require_once $pathToController;
            $controllerClass = "\controllers\\$controller\\$controller";
            $controller = new $controllerClass();
            
            // Call controller method
            (empty($methodParams)) ? $controller->{$method}() : $controller->{$method}(...array_values($methodParams));

        } else {
            echo $pathToController;
            echo 'error no existe controlador';
        }
    }
}

