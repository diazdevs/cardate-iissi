<?php

namespace models\concepto;

class Concepto extends \Model {
    const TABLE_NAME = 'CONCEPTOS';

    public $id;
    public $titulo;
    public $cantidad;
    public $mano_de_obra;
    public $precio;
    public $precio_unitario;
    public $precio_final;
    public $coste_personal;
    public $coste_piezas;
    public $finalizado;
    public $id_recambio;
    public $id_presupuesto;
    

}

?>