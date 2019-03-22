<?php

namespace forms\cita;

class FormCita extends \Form {
    const CLASE = 'Cita';

    protected $fields = array(
        'id_vehiculo' => array('required'=>true),
        'hora_inicio' => array('required'=>true),
        'hora_fin' => array('required'=>true),
        'motivo' => array('enum'=>array('reparacion', 'cambio pieza', 'capa pintura', 'revision'),),
        'descripcion_motivo' => array('required'=>true)
    );

    public function clean(){
        $datos = parent::clean();
        $hora_inicio = new \DateTime($datos['hora_inicio']);
        $hora_fin = new \DateTime($datos['hora_fin']);
        $formato = 'DD/MM/RR HH24:MI:SSXFF';
        $datos['hora_inicio'] =  $hora_inicio -> format('d/m/Y H:i:s');
        $datos['hora_fin'] =  $hora_fin -> format('d/m/Y H:i:s');

        $this->data = $datos;
    }
}

?>