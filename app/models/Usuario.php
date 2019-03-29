<?php

namespace models\usuario;

class Usuario extends \Model {

    const TABLE_NAME = 'USUARIOS';

    public $id;
    public $dni;
    public $email;
    public $contrasenya;
    public $activo;
    public $correo_confirmado;
    public $nombre;
    public $apellidos;
    public $telefono;
    public $fecha_creacion;
    public $es_admin;


        public static function registrar($datos){

            try {
                Usuario::create($datos);
                // Iniciamos sesion
                $_SESSION['email_usuario'] = $datos['email'];
                return true;
            } catch (Exception $e){
                return false;
            }

        }

        public static function login($datos){
            $usuario = Usuario::get(array('email'=>$datos['email']));

            // Si existe un cliente con ese email y ademas con esa contrasenya, creamos la sesion
            if ($usuario and password_verify($datos['password'], $usuario->contrasenya)){
                $_SESSION['email_usuario'] = $datos['email'];
                return true;
            } else {
                return false;
            }
            
            return false;
        }

        public static function current() {
            if (isset($_SESSION['email_usuario'])){
                $usuario = Usuario::get(array('email'=>$_SESSION['email_usuario']));
                // Comprobamos que existe un usuario con ese email para evitar errores despues
                // de eliminar un usuario o cambiarle el email
                if ($usuario) {
                    return $usuario;
                } else {
                    unset($_SESSION['email_usuario']);
                }
            }

            return false;
        }

        public static function es_admin(){
            $usuario = static::current();
            return $usuario && $usuario->es_admin;
        }

}