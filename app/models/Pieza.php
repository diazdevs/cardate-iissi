<?php

namespace models\pieza;

class Pieza extends \Model {
    const TABLE_NAME = 'PIEZAS';

    public $id;
    public $codigo;
    public $marca;
    public $tipo;
    public $tipo_url;
    public $url_imagen;
    public $descripcion;

    public static function filtrarPorModelo($id_modelo){
        $query = "SELECT id_pieza FROM vehiculo_piezas WHERE id_modelo = :id_modelo";
        $res = static::requestDb($query, ['id_modelo'=>$id_modelo,]);
        $ids_piezas = $res->fetch();

        $ids_piezas = join(", ", $ids_piezas);
        $query = "SELECT * FROM PIEZAS WHERE id in ($ids_piezas)";

        $res = static::requestDb($query);
        return $res->fetchAll(\PDO::FETCH_CLASS, Pieza::class);
    }
}

?>