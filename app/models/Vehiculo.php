<?php

namespace models\vehiculo;

class Vehiculo extends \Model {
    const TABLE_NAME = 'VEHICULOS';

    public $id;
    public $matricula;
    public $estado;
    public $id_usuario;
    public $id_modelo;

    // Foreign keys
    private $modelo;
    private $usuario;
    
    
    public function getModelo(){
        if ($this->modelo == null) {
            $this->modelo = $this->getForeignKey("modelo");
        }
        return $this->modelo;
    }

    public function getUsuario(){
        if ($this->usuario == null) {
            $this->usuario = $this->getForeignKey("usuario");
        }
        return $this->usuario;
    }

}

?>