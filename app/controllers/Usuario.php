<?php

namespace controllers\usuario;
require 'app/forms/Usuario.php';
require 'app/models/Usuario.php';

use \models\usuario\Usuario as ModeloUsuario;
use \forms\usuario\FormLogin;
use \forms\usuario\FormRegistro;


class Usuario extends \Controller {

    public function login(){
        $this->checkAuth($redirect_url='/nopuedestarlogged', $logged=false);

        if ($this->isPost()){
            $formulario = new FormLogin($_POST);

            if ($formulario->valid()){
                if (ModeloUsuario::login($formulario->getData())){
                    $this->redirect('/');
                } else {
                    $this->render('login.html', ['errores'=>['Contraseña o email incorrectos.',]]);
                }
            } else {
                $this->render('login.html', ['errores'=>$formulario->errors]);
            }
        } else {
            $this->render('login.html');
        }
    }

    public function register(){
        $this->checkAuth($redirect_url='/nopuedestarlogged', $logged=false);

        if ($this->isPost()){
            $formulario = new FormRegistro($_POST);

            if ($formulario->valid()){
                $nuevoUsuario = ModeloUsuario::registrar($formulario->getData());

                if ($nuevoUsuario){
                    $_SESSION['email_usuariol'] = $formulario->getData()['email'];
                    $this->redirect('/');
                } else {
                    $this->render('registro.html', ['form'=>$_POST, 'errores'=>['Error creando usuario',]]);
                }
            } else {
                $this->render('registro.html', ['form'=>$_POST, 'errores'=>$formulario->errors]);
            }

        } else {
            $this->render('registro.html');
        }
    }

    public function logout(){
        if (isset($_SESSION['email_usuario']))
            unset($_SESSION['email_usuario']);
        
        $this->redirect('/');
    }

}