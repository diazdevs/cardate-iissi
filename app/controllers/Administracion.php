<?php

namespace controllers\administracion;
require_once 'app/models/usuario.php';
require 'app/models/cita.php';
require 'app/models/vehiculo.php';
require 'app/models/pieza.php';

use \models\usuario\Usuario;
use \models\vehiculo\Vehiculo;
use \models\cita\Cita;
use \models\pieza\Pieza;

class Administracion extends \Controller{

    public function __construct() {
        parent::__construct();
        // Comprobamos que el usuario es admin y si no devolvemos 404         
        if (!Usuario::es_admin())
            $this->http404();
    }

    public function index() {
        $this->render('administracion/index.html');
    }

    public function citas() {

        $usuario = Usuario::current();
        $citas = Cita::all();
        $this->render('administracion/citas.html', [
            'usuario' => $usuario,
            'citas' => $citas
        ]);

    }

    public function clientes() {

        $usuario = Usuario::current();
        $clientes = Usuario::all();
        $this->render('administracion/clientes.html', [
            'clientes' => $clientes,
            'usuario' => $usuario,
        ]);

    }

    public function clientes_detalle($id_cliente){

        $usuario = Usuario::current();
        $cliente = Usuario::get(['id'=>$id_cliente]);
        

        if (!$cliente){
            $this->http404();
        }

        $citasCliente = Cita::filter(['id_usuario'=>$id_cliente]);
        $vehiculosCliente = Vehiculo::filter(['id_usuario'=>$id_cliente]);

        $this->render('administracion/clientes_detalle.html', [
            'cliente' => $cliente,
            'usuario' => $usuario,
            'citas' => $citasCliente,
            'vehiculos' => $vehiculosCliente,
        ]);
    }

    public function vehiculos() {

        $usuario = Usuario::current();
        $vehiculos = Vehiculo::all();

        $this->render('administracion/vehiculos.html', [
            'vehiculos' => $vehiculos,
            'usuario' => $usuario
        ]);

    }

    public function presupuestos() {
        $this->render('administracion/presupuestos.html');
    }

    public function crearPresupuesto($id_cita){

        $cita = Cita::get(["id"=>$id_cita]);
        if (!$cita) $this->http404();

        $piezasVehiculo = Pieza::filtrarPorModelo($cita->vehiculo->modelo->id);

        // do stuff

        $this->render('administracion/crear_presupuesto.html', [
            'cita' => $cita,
            'piezasVehiculo' => $piezasVehiculo,          
        ]);
    }

}