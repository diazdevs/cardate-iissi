<?php

namespace controllers\vehiculo;

require_once 'app/models/modelo.php';
require_once 'app/models/usuario.php';
require_once 'app/models/vehiculo.php';
require_once 'app/forms/vehiculo.php';

use \models\modelo\Modelo;
use \models\usuario\Usuario;

use \models\vehiculo\Vehiculo as ModeloVehiculo;
use \forms\vehiculo\VehiculoForm;


class Vehiculo extends \Controller {

    /**
     * @todo implemetar formulario
     */
    public function create(){
        $this->checkAuth($logged=true);
        $usuario = Usuario::current();

        $modelos = Modelo::all();
        
        if ($this->isPost()){
            $formulario = new VehiculoForm($_POST);
            if ($formulario->valid()){
                ModeloVehiculo::create([
                    'matricula' => $formulario->getData()['matricula'],
                    'id_modelo' => $formulario->getData()['id_modelo'],
                    'id_usuario' => $usuario->id,
                ]);
                $this->redirect('/citas/crear');
            } else {
                $this->render('crear_vehiculo.html', [
                    'modelos' => $modelos,
                    'usuario' => $usuario,
                    'errores' => $formulario->errors
                ]);
            }
        } else {
            
        
            $this->render('crear_vehiculo.html', [
                'modelos' => $modelos,
                'usuario' => $usuario,
            ]);
        }
    }
}