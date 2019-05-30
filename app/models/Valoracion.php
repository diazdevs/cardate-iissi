<?php

namespace models\cita;

class Cita extends \Model {
    const TABLE_NAME = 'VALORACIONES';

    public $id;
    public $mensaje;
    public $puntuacion;
    public $publicado;
    public $fecha_creacion;
    public $id_cita;

}

?>