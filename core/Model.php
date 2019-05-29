<?php


// Template engine
require_once 'vendor/autoload.php';


/**
 * Transforms $params array into a query ready string
 */
function transformValues($params) {
    return join(" AND ", array_map(
        function ($str) { return "$str = :$str"; },
        array_keys($params)));
}


class Model {
    /**
     * @author Jose Gamaza Díaz
     * Esta clase facilita la conexion con las tablas de la BD
     * y las clases en PHP
     * 
     * methods:
     *  requestDB($query) => executes query
     *  all($columns) => SELECT $columns FROM table
     *  filter($params, $columns) => SELECT $columns FROM table WHERE $params
     *  count($params) => SELECT count(*) FROM table WHERE $params
     *  exists($params) => (bool)count($params)
     *  create($params) => INSERT INTO table ($params_keys) VALUES ($params_values)
     *  save() => UPDATE table SET (changed_columns) WHERE id=this.id
     *  delete() => DELETE FROM table WHERE $params
     */

    const TABLE_NAME = null;

    public function __get($name){
        if (isset($this->$name)){
            return $this->$name;

        } else if (isset($this->{"id_$name"})) {
            $class =  "\models\\$name\\$name";
            if (!class_exists($class))
                require_once "app/models/$name.php";
            return $class::get(['id'=>$this->{"id_$name"}]);

        }
    }

    public static function requestDb($query, $params=false) {
        // Ver mas sobre try-catch https://phpdelusions.net/delusion/try-catch
        global $connection;
        try {
            $db = $connection->db;
            $request = $db->prepare(str_replace(':TABLE_NAME', static::TABLE_NAME, $query));
    
            if ($params) {
                $request->execute($params);
            } else {
                $request->execute();
            }
    
            return $request;
        } catch (PDOException $e) {
            $loader = new \Twig\Loader\FilesystemLoader('app/views');
            $twig = new \Twig\Environment($loader);
        
            $ctx['error'] = $e->getMessage();
            echo $twig->render("error.html", $ctx);
            exit;
        }

        
    }

    public static function all($columns=['*']) {
        // Pedimos todas las columnas o solo algunas
        $query = "SELECT " . join(',', $columns) . " FROM :TABLE_NAME";
        $res = static::requestDb($query);
        return $res->fetchAll(PDO::FETCH_CLASS, static::class);
    }

    public static function filter($params, $columns=['*']) {
        // Pedimos todas las columnas o solo algunas
        $values = transformValues($params);
        $query = "SELECT " . join(',', $columns) . " FROM :TABLE_NAME WHERE ($values)";
        $res = static::requestDb($query, $params);
        return $res->fetchAll(PDO::FETCH_CLASS, static::class);
    }

    public static function get($params, $columns=['*']){
        return current(static::filter($params, $columns));
    }

    public static function count($params=[]) {
        $query = "SELECT COUNT(*) FROM :TABLE_NAME";
        if ($params)
            $values = transformValues($params);
            $query .= " WHERE ($values)";
        return static::requestDb($query, $params)->fetchColumn();
    }
    
    public static function exists($params) {
        return (bool)static::count($params);
    }

    public static function create($params) {
        $values = join(",", array_map(function($val){return ":$val";}, array_keys($params)));
        $columns = join(",", array_keys($params));
        $query = "INSERT INTO :TABLE_NAME ($columns) VALUES ($values)";
        // print_r(static::class);
        return static::requestDb($query, $params) !== false;
    }

    /**
     * Not implemented
     */
    public static function save() {
        $columns = get_object_vars(static::class);
        $changed_columns = join(",", array_map(
            function ($column) {
                $value = $this->{$column};
                return "$column = $value";
            }, array_keys($array_filter($columns))));
        $query = "UPDATE :TABLE_NAME SET ($changed_columns) WHERE ID=" . $this->id;
        $saved = static::requestDb($query);
        return $saved;
    }

    // Bulk delete
    public static function delete($params){
        $values = transformValues($params);
        $query = "DELETE FROM :TABLE_NAME WHERE ($values)";
        $deleted = static::requestDb($query, $params);
        //  devuelve si alguna fila se ha eliminado
        return $eliminado->rowCount() > 0;
    }
    

}


?>