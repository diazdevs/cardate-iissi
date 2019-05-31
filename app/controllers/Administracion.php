<?php

namespace controllers\administracion;
require_once 'app/models/usuario.php';
require 'app/models/cita.php';
require 'app/models/vehiculo.php';
require 'app/models/pieza.php';
require 'app/models/recambio.php';
require 'app/models/presupuesto.php';
require 'app/models/concepto.php';

use \models\usuario\Usuario;
use \models\vehiculo\Vehiculo;
use \models\cita\Cita;
use \models\pieza\Pieza;
use \models\recambio\Recambio;
use \models\presupuesto\Presupuesto;
use \models\concepto\Concepto;

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


        if ($this->isPost()){

            $p_precioMano = $_POST['precioMano'];
            $p_iva = $_POST['iva'];


            $presupuesto_id = Presupuesto::create([
                // 'iva' => floatval($p_iva) / 100,
                'precio_hora' => str_replace('.', ',', $p_precioMano),
                'id_cita' => $id_cita,
            ]);


            $piezas_ids = $_POST['conceptoPiezas'];
            $conceptoTitulos = $_POST['conceptoTitulo'];
            $conceptoCantidadPieza = $_POST['conceptoCantidadPieza'];
            $conceptoManoObra = $_POST['conceptoManoObra'];
            $conceptoPrecioPieza = $_POST['conceptoPrecioPieza'];

            $conceptos = validaPresupuesto($p_precioMano, $p_iva, $piezas_ids,
                $conceptoTitulos, $conceptoCantidadPieza, $conceptoManoObra, $conceptoPrecioPieza);
            
            
            $now = new \DateTime();
            $fecha_llegada_temporal = $now->format('d/m/Y H:i:s');

            foreach($conceptos as $concepto) {
                $recambio_id = Recambio::create([
                    'id_pieza' => $concepto['id_pieza'],
                    'proveedor' => 'proveedor nombre',
                    'coste_unidad' => $concepto['precio_pieza'],
                    'cantidad' => $concepto['cantidad'],
                    'fecha_llegada' => $fecha_llegada_temporal,
                ]);

                unset($concepto['id_pieza']);
                unset($concepto['precio_pieza']);
                $concepto['id_recambio'] = $recambio_id;
                $concepto['id_presupuesto'] = $presupuesto_id;
                $concepto = Concepto::create($concepto);
            }

            $this->redirect('/');

        }

        // Presupuesto::create([
        //     'id_cita' => $id_cita,
        // ]);

        // do stuff

        $this->render('administracion/crear_presupuesto.html', [
            'cita' => $cita,
            'piezasVehiculo' => $piezasVehiculo,          
        ]);
    }

}


function validaPresupuesto($p_precioMano, $p_iva, $piezas_ids,
    $conceptoTitulos, $conceptoCantidadPieza, $conceptoManoObra, $conceptoPrecioPieza){

        $sizes = [
            $piezas_ids,
            $conceptoTitulos,
            $conceptoCantidadPieza,
            $conceptoManoObra,
            $conceptoPrecioPieza,
        ];

        $equal_sizes = count(array_unique(array_map(
            function($obj){return sizeof($obj);},
            $sizes))) === 1;

        if (!$equal_sizes) return false;

        $conceptos = [];

        $i = 0;
        while($i < sizeof($piezas_ids)){
            array_push($conceptos, [
                'id_pieza' => $piezas_ids[$i],
                'titulo' => $conceptoTitulos[$i],
                'cantidad' => $conceptoCantidadPieza[$i],
                'mano_de_obra' => $conceptoManoObra[$i],
                'precio_pieza' => $conceptoPrecioPieza[$i]
            ]);
            $i = $i + 1;
        }

        return $conceptos;


    }