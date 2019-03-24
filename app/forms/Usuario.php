<?php

namespace forms\usuario;

// Codifica contrasenña
function codificar_pass($pass){
    return password_hash($pass, PASSWORD_DEFAULT);
}

# https://www.bufa.es/php-funcion-validar-dni/
function validar_dni($dni){
    $letra = substr($dni, -1);
    $numeros = substr($dni, 0, -1);
    if (is_numeric($numeros) and ctype_alpha($letra)){
        return substr("TRWAGMYFPDXBNJZSQVHLCKE", $numeros%23, 1) == $letra && strlen($letra) == 1 && strlen ($numeros) == 8;
    } else {
        return false;
    }
}

function validar_telefono($telefono){
    /* implementar */
    return true;
}


class FormLogin extends \Form {
    const CLASE = 'Usuario';

    protected $fields = array(
        'email' => array('required'=>true),
        'password' => array('required'=>true),
    );
    
    public function clean(){
        $data = parent::clean();
        $data['email'] = strtolower($data['email']);
        $this->data = $data;
    }
}

class FormRegistro extends \Form {
    const CLASE = 'Usuario';
    
    protected $fields = array(
        'nombre' => array('required'=>true),
        'apellidos' => array('required'=>true),
        'dni' => array('required'=>true, 'unique'=>true),
        'telefono' => array(), 
        'email' => array('required'=>true, 'unique'=>true),
        'contra1' => array('required'=>true),
        'contra2'=> array('required'=>true)
    );
    

    public function getData(){
        $data = $this->data;
        // Encriptamos contraseña y eliminamos keys sobrantes
        $data['contrasenya'] = codificar_pass($data['contra1']);
        unset($data['contra1']);
        unset($data['contra2']);
        
        return $data;
    }

    protected function clean(){

        $data = parent::clean();

        $data['nombre'] = mb_convert_case($data['nombre'], MB_CASE_TITLE, "UTF-8");
        $data['apellidos'] = mb_convert_case($data['apellidos'], MB_CASE_TITLE, "UTF-8");
        $data['telefono'] = $data['telefono'];
        $data['email'] = strtolower($data['email']);
        $data['dni'] = strtoupper($data['dni']);

        $this->data = $data;
    
    }

    public function valid(){

        $errors = $this->errors;
        $validacion_basica = parent::valid(); // Incluye saneamiento
        
        // Si la validacion básica ha dado error no hace falta que sigamos validando ?
        if (!$validacion_basica) return false;

        // En caso contrario realizamos validacion especifica
        $data = $this->data;

        // Comprobamos que las dos contraseñas son iguales
        if ($data['contra1'] != $data['contra2'])
            $errors['contra2'] = 'Las Contraseñas no coinciden';
        // Comprobamos que el formato del dni es correcto
        if (!validar_dni($data['dni']))
            $errors['dni'] = 'Formato dni incorrecto.';
        // Comprobamos que el formato del telefono es valido
        if (!validar_telefono($data['telefono']))
            $errors['telefono'] = 'Formato telefono incorrecto.';
    
        
        // Actualizamos errores
        $this->errors = $errors;

        return empty($errors);

    }

}