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
    public $id_usuario;

    // Foreign keys
    private $vehiculo;
    private $usuario;
    
    
    public function getVehiculo(){
        if ($this->vehiculo == null) {
            $this->vehiculo = $this->getForeignKey("vehiculo");
        }
        return $this->vehiculo;
    }

    public function getUsuario(){
        if ($this->usuario == null) {
            $this->usuario = $this->getForeignKey("usuario");
        }
        return $this->usuario;
    }

}

?>