<?php

namespace controllers\administracion;
require_once 'app/models/usuario.php';

use \models\usuario\Usuario;

class Administracion extends \Controller{

    public function __construct(){
        parent::__construct();
        // Comprobamos que el usuario es admin y si no devolvemos 404         
        if (!Usuario::es_admin())
            $this->http404();
    }

    public function index(){
        $this->render('administracion/index.html');
    }

    public function citas(){
        $this->render('administracion/citas.html');
    }

    public function presupuestos(){
        $this->render('administracion/presupuestos.html');
    }

    public function crearPresupuesto(){
        $this->render('administracion/crear_prespuesto.html');
    }

}