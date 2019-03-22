<?php

class Database {
    /**
     * Establishes a PDO connection
     */
    public $db;

    public function __construct(){
        $this->db = $this->connect();
    }

    public function connect($options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_EMULATE_PREPARES  => false,
            PDO::ATTR_CASE => PDO::CASE_LOWER]) {
        
        try {
            $connection = constant('DBTYPE') . ":dbname=" . constant('DB') . ";charset=" . constant('CHARSET');
            return new PDO($connection, constant('USER'), constant('PASSWORD'), $options);
        } catch (PDOException $e) {
            print_r('Error connection: ' . $e->getMessage());
        }
    }

    public function close(){
        unset($this->db);
    }

}

?>