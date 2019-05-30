<?php

namespace controllers\administracion;
require_once 'app/models/usuario.php';
require 'app/models/cita.php';
require 'app/models/vehiculo.php';

use \models\usuario\Usuario;
use \models\vehiculo\Vehiculo;
use \models\cita\Cita as ModeloCita;

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
        $this->checkAuth($logged=true);

        $usuario = Usuario::all();
        $citas = ModeloCita::all();
        $this->render('administracion/citasAdmin.html', [
            'usuario' => $usuario,
            'citas' => $citas
        ]);
    }

    public function presupuestos(){
        $this->render('administracion/presupuestos.html');
    }

    public function crearPresupuesto(){
        $this->render('administracion/crear_prespuesto.html');
    }

}