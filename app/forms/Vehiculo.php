<?php

namespace forms\vehiculo;

class VehiculoForm extends \Form{
    const CLASE = 'Vehiculo';
    protected $fields = [
        'matricula' => array('unique'=>true),
        'id_modelo' => array('required'=>true),
    ];
}