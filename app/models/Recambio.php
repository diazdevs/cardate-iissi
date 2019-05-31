<?php

namespace models\recambio;

class Recambio extends \Model {
    const TABLE_NAME = 'RECAMBIOS';

    public $id;
    public $fecha_llegada;
    public $proveedor;
    public $coste_unidad;
    public $cantidad;
    public $id_pieza;
    

}

?>