<?php

// namespace core;

class Form {
    /**
     * @author Jose Gamaza Diaz
     * The objective of this class is to be able to validate forms in a more pleasant
     * and simple way without having to repeat similar code each time we want to validate
     * a specfic form.
     *
     * basic properties:
     *  - fields:
     *      1. required. Verificamos que el campo no esta vacio
     *      2. unique. Verificamos que no existe ningun objeto en la bd con el mismo valor
     *      3. maxLength. Verificamos que la longitud no es mayor a un valor dado
     *      4. minLength. Verificamos que la longitud no es menor a un valor dado
     *      5. enum. Verificamos que el valor del campo esta dentro de los elem del enum
     *      @todo 6. foreignkey. Verificamos que el id existe 
     *      @todo 7. tipo. comprobamos si el formato de un email, fecha u otro es correcto 
     *      @todo 8. pattern. comprueba si cumple un patron 
     *  - errores
     *  - request
    */

    const CLASE = null; // Name of the model used

    public $errors; // Form validation errors
    protected $data; // Peticion saneada
    protected $request; // Parametros y valores de peticiones $_POST/$_GET
    protected $fields; // Campos del formulario
    

    public function __construct($request) {
        $this->request = $request;
    }

    public function getData(){
        return $this->data;
    }

    protected function validateFields($request){

        // Inicializamos la variable errors con un array vacio
        $errors = [];

        foreach($this->fields as $field => $requirements){

            // Arreglo bug temporal
            $options = array_keys($requirements);

            // Comprobamos que no esta vacio si es requerido
            // Por otro lado, si un campo es unico no debe estar vacio
            // BUG EN SELECT ARREGLAR
            if (in_array('required', $options) or in_array('unique', $options)){
                if (empty($request[$field])){
                    $errors[$field] = ucfirst("$field is required.");
                    continue;
                }
            }

            // Comprobamos que no existe ningun objeto con el mismo valor de campo
            /**
             * @todo fixme
             */
            if (in_array('unique', $options)){
                $clase = static::CLASE;
                $clase = '\models\\' . $clase . '\\' . $clase;
                if ($clase::exists(array($field=>$request[$field]))){
                    $errors[$field] = ucfirst("$field ya existe.");
                    continue;
                }
            }
            

            // Comprobamos que pertenece al enum
            if (in_array('enumerated', $options)){
                if (!in_array($request[$field], $requirements['enum'])){
                    $enum = join(', ', $requirements['enum']);
                    $errors[$field] = ucfirst("$field debe ser $enum");
                    continue;
                }
            }

            // Comprobamos limites de longitud maxima
            if (in_array('maxLength', $options)){
                if (strlen($request[$field]) > $requirements['maxLength']){
                    $long =  $requirements['maxLength'];
                    $errors[$field] = ucfirst("$field no puede tener mas de $long carácteres");
                    continue;
                }
            }

            // Comprobamos limites de longitud minima
            if (in_array('minLength', $options)){
                if (strlen($request[$field]) < $requirements['minLength']){
                    $long =  $requirements['minLength'];
                    $errors[$field] = ucfirst("$field no puede tener menos de $long carácteres");
                }
            }


        }

        // Actualizamos errores
        $this->errors = $errors;
        return empty($errors);

    }

    protected function clean() {
        // Eliminamos parametros recibidos no deseados para evitar posibles ataques
        $this->data = array_intersect_key($this->request, $this->fields);
        return $this->data;
    }

    public function valid(){
        // Comprobamos que no falta ningun campo en el formulario
        $received_fields = true;
        foreach($this->fields as $field => $requirement){
            if (!isset($this->request[$field])){
                $received_fields = false;
                break;
            }
        }

        // // Si se han recibido todos los campos procedemos a validar
        if ($received_fields){
            // Primero saneamos los datos
            $this->clean();

            // Realizamos la validacion basica de campos (required, unique, max, min)
            return $this->validateFields($this->data);
        } else {
            $this->errors['campo_no_recibido'] = 'No ha enviado todos los campos necesarios';
            return false;
        }
    }
}

?>