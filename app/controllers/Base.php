<?php

namespace controllers\base;
require_once 'app/models/usuario.php';
require_once 'app/models/marca.php';
require_once 'app/models/modelo.php';

use \models\usuario\Usuario;
use \models\marca\Marca;
use \models\modelo\Modelo;


class Base extends \Controller {

    public function index(){
        $usuario = Usuario::current();
        $marcas = Marca::all();
        $modelos = Modelo::all(['nombre', 'nombre_version']);

        $this->render('index.html', [
            'usuario' => $usuario,
            'marcas'=> $marcas,
            'modelos' => array_map(function($obj){return $obj->nombre;}, $modelos),
            'versiones' => array_map(function($obj){return $obj->nombre_version;}, $modelos),

        ]);
    }

    public function about(){
        echo 'Pagina sobre nosotros';
    }

    public function terminos(){
        echo 'Terminos y condiciones';
    }

    public function privacidad(){
        echo 'Politicas de privacidad';
    }

    public function contacto(){
        $this->render('contacto.html');

    }

}