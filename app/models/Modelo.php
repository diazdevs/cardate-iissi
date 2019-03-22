<?php

namespace models\modelo;

class Modelo extends \Model {
    const TABLE_NAME = 'MODELOS';

    public $id;
    public $nombre;
    public $nombre_version;
    public $url_informacion;
    public $body_type;
    public $drive_type;
    public $fuel_supply_type;
    public $engine_code;
    public $engine_displacement;
    public $engine_manufacturer;
    public $engine_type;
    public $engine_design;
    public $engine_cylinders;
    public $engine_cylinder_head_type;
    public $engine_valves;
    public $engine_litres;
    public $engine_compression_ratio;
    public $engine_aspiration_type;
    public $engine_cooling_type;
    public $engine_timing_control_type;
    public $tipo;
    public $id_marca;

}

?>