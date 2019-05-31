<?php

namespace models\presupuesto;

class Presupuesto extends \Model {
    const TABLE_NAME = 'PRESUPUESTOS';

    public $id;
    public $coste_personal;
    public $coste_piezas;
    public $precio_hora;
    public $preferencia;
    public $iva;
    public $impuestos;
    public $precio;
    public $precio_final;
    public $fecha_creacion;
    public $aceptado;
    public $id_cita;
    

}

?>