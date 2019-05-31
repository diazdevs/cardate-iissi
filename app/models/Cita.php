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
    public $id_cliente;

    private $cliente = null;

    public function getCliente(){
        if ($this->cliente == null){
            $class =  "\models\\usuario\\usuario";
            if (!class_exists($class))
                require_once "app/models/usuario.php";
            
            $this->cliente = $class::get(['id'=>$this->id_cliente]);
        } 
        return $this->cliente;
        
    }

}

?>