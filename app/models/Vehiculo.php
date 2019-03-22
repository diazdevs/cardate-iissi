<?php

namespace models\vehiculo;

class Vehiculo extends \Model {
    const TABLE_NAME = 'VEHICULOS';

    public $id;
    public $matricula;
    public $estado;
    public $id_cliente;
    public $id_modeo;

}

?>