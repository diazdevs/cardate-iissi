<?php

namespace controllers\crawler;

/**
 * controlador temporal
 * carga modelos de vehiculos de http://www.vehiclepartsdatabase.com/vehicles/allprivateroadvehicles
 */
class Crawler {

    public function crawler(){
        require_once 'app/utils/cargarModelos.php';
    }
}