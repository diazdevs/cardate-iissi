<?php

namespace controllers\cita;
require 'app/models/usuario.php';
require 'app/models/cita.php';
require 'app/models/vehiculo.php';
require 'app/models/presupuesto.php';
require 'app/models/concepto.php';

require 'app/forms/cita.php';

use \models\usuario\Usuario;
use \models\vehiculo\Vehiculo;
use \models\presupuesto\Presupuesto;
use \models\concepto\Concepto;
use \models\cita\Cita as ModeloCita;

use \forms\cita\FormCita;

class Cita extends \Controller {

    public function citas(){
        $this->checkAuth($logged=true);

        $usuario = Usuario::current();
        $citas = ModeloCita::filter(['id_usuario'=>$usuario->id]);
        $this->render('citas.html', [
            'usuario' => $usuario,
            'citas' => $citas
        ]);
    }

    public function crearCita(){
        $this->checkAuth($logged=true);
        
        $usuario = Usuario::current();
        $citas = ModeloCita::all(['hora_inicio',]);
        
        $context = [
            'usuario' => $usuario,
            'vehiculos' => Vehiculo::filter(['id_usuario'=>$usuario->id]),
            'citas' => $citas,
        ];

        if ($this->isPost()){
            $formulario = new FormCita($_POST);
            if ($formulario->valid()){
                $datos = $formulario->getData();
                $datos['id_usuario'] = $usuario->id;
                ModeloCita::create($datos);
                $this->redirect('/citas');
            } else {
                $context['errores'] = $formulario->errors;
            }
        }

        $this->render('crear_cita.html', $context);
    }

    public function verCita($id){
        $this->checkAuth($logged=true);

        $usuario = Usuario::current();
        $cita = ModeloCita::get(['id'=>$id, 'id_usuario'=>$usuario->id]);
        
        if (!$cita){
            $this->http404();
        }

        $presupuesto = Presupuesto::get(['id_cita'=>$id]);
        $conceptos = [];

        if ($presupuesto){
            $conceptos = Concepto::filter(['id_presupuesto'=>$presupuesto->id]);
        }

        $this->render('detalle_cita.html', [
            'cita'=>$cita,
            'usuario'=>Usuario::current(),
            'presupuesto' => $presupuesto,
            'conceptos' => $conceptos,
        ]);
    }

}