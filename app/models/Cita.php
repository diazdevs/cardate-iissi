<?php

namespace models\cita;

class Cita extends \Model {
    const TABLE_NAME = 'CITAS';

    public $id;
    public $hora_inicio;
    public $hora_fin;
    public $fecha_creacion;
    public $motivo;
    public $descripcion_motivo;
    public $id_vehiculo;

}

?>