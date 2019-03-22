<?php

use Goutte\Client;

require 'app/models/marca.php';
require 'app/models/modelo.php';
use \models\marca\Marca;
use \models\modelo\Modelo;


// https://symfony.com/doc/current/components/dom_crawler.html?any


$marcas = array();



function getMarcas(){
    $client = new Client();
    $url_marcas = 'http://www.vehiclepartsdatabase.com/vehicles/allprivateroadvehicles';
    $crawler = $client->request('GET', $url_marcas);
    $marcas = $crawler->filter('.grid-whole > a')->extract(['_text', 'href']);
    return $marcas;
}

function cargarMarca($url_marca){
    $client = new Client();
    $url_marca = 'http://www.vehiclepartsdatabase.com' . $url_marca;
    $crawler = $client->request('GET', $url_marca);
    $modelos = $crawler->filter('.grid-half > a')->extract(['_text', 'href']);
    $imagenMarca = $crawler->filter('.grid-whole > img')->extract(['src']);
    return [
        'imagenMarca'=>$imagenMarca[0],
        'modelos'=>$modelos
    ];
}

function cargarModelo($url_modelo){
    $client = new Client();
    $url_modelo = 'http://www.vehiclepartsdatabase.com' . $url_modelo;
    $crawler = $client->request('GET', $url_modelo);
    $versiones = $crawler->filter('.grid-whole > a')->extract(['_text', 'href']);
    return $versiones;
}

function cargarVersion($url_version){
    $client = new Client();
    $url_version = 'http://www.vehiclepartsdatabase.com/' . $url_version;
    $crawler = $client->request('GET', $url_version);
    // $piezas = $crawler->filter('.grid-whole .left')->filter('a')->extract(['_text', 'href']);
    $propiedades = $crawler->filter('.grid-10 > div')->extract(['_text']);
    $res = [];

    foreach($propiedades as $key => $value) {
        if($key % 2 != 0)
            continue;
        $res[$propiedades[$key]] = $propiedades[$key+1];
    }
    
    return $res;
}

// print_r(cargarVersion('vehicles/allprivateroadvehicles/acura/clcoupe/22/f22b2/25906'));

function actualizarModelos(){
    $marcas = getMarcas();
    foreach($marcas as $marca){
        $nombreMarca = $marca[0];
        $marca = cargarMarca($marca[1]);
        if (!Marca::exists(['nombre'=>$nombreMarca])){
            Marca::create(['nombre'=>$nombreMarca, 'url_imagen'=>$marca['imagenMarca']]);
            $id_marca = Marca::get(['nombre'=>$nombreMarca])->id;


            foreach($marca['modelos'] as $modelo){
                $nombreModelo = $modelo[0];
                $versiones = cargarModelo($modelo[1]);

                foreach($versiones as $version){
                    $nombreVersion = $version[0];
                    $url_informacion = $version[1];

                    if (!Modelo::exists(['nombre'=>$nombreModelo, 'nombre_version'=>$nombreVersion])){
                        $version = cargarVersion($version[1]);
                        Modelo::create([
                            'nombre' => $nombreModelo,
                            'nombre_version' => $nombreVersion,
                            'url_informacion' => $url_informacion,
                            'body_type' => isset($version['Body Type']) ? $version['Body Type'] : null,
                            'drive_type' => isset($version['Drive Type']) ? $version['Drive Type'] : null,
                            'fuel_supply_type' => isset($version['Fuel Supply Type']) ? $version['Fuel Supply Type'] : null,
                            'engine_code' => isset($version['Code']) ? $version['Code'] : null,
                            'engine_displacement' => isset($version['Engine Displacement']) ? $version['Engine Displacement'] : null,
                            'engine_manufacturer' => isset($version['Engine Manufacturer']) ? $version['Engine Manufacturer'] : null,
                            'engine_type' => isset($version['Engine Type']) ? $version['Engine Type'] : null,
                            'engine_design' => isset($version['Engine Design']) ? $version['Engine Design'] : null,
                            'engine_cylinders' => isset($version['Cylinders']) ? $version['Cylinders'] : null,
                            'engine_cylinder_head_type' => isset($version['Cylinder Head Type']) ? $version['Cylinder Head Type'] : null,
                            'engine_valves' => isset($version['Valves']) ? $version['Valves'] : null,
                            'engine_litres' => isset($version['Litres']) ? $version['Litres'] : null,
                            // 'engine_compression_ratio' => isset($version['']) ? $version[] : null,
                            'engine_aspiration_type' => isset($version['Aspiration Type']) ? $version['Aspiration Type'] : null,
                            'engine_cooling_type' => isset($version['Cooling Type']) ? $version['Cooling Type'] : null,
                            'engine_timing_control_type' => isset($version['Timing Control Type']) ? $version['Timing Control Type'] : null,
                            'tipo' => 'coche',
                            'id_marca' => $id_marca,
                        ]);
                    }

                }
            }
    }

    }
}

if (isset($_GET['actualizar'])){
    // set_time_limit(300); // actualziar maximum execution time 5minutes
    //https://stackoverflow.com/questions/5164930/fatal-error-maximum-execution-time-of-30-seconds-exceeded
    actualizarModelos();
}


?>
<style>
    .reloj {
        float: left;
        font-size: 80px;
        font-family: Courier, sans-serif;
        color: #363431;
    }
    .clearfix {
        overflow: auto;
  }
}
</style>
<!-- https://codepen.io/Romlonix/pen/Fwsza -->
<div class="clearfix">
    <div class="reloj" id="Horas">00</div>
    <div class="reloj" id="Minutos">:00</div>
    <div class="reloj" id="Segundos">:00</div>
    <div class="reloj" id="Centesimas">:00</div>
</div>
<br>
<hr>
<div>
    <h2>¿Esta seguro que quiere actualizar la base de datos de modelos?</h2>
    <p>Tiempo estimado: 30 minutos</p>
    <a href="?actualizar=true" onclick="inicio();">Actualizar</a>
    <a href="#" onclick="window.stop();">Parar</a>
</div>

<script>
var centesimas = 0;
var segundos = 0;
var minutos = 0;
var horas = 0;
function inicio () {
	control = setInterval(cronometro,10);
	document.getElementById("inicio").disabled = true;
	document.getElementById("parar").disabled = false;
	document.getElementById("continuar").disabled = true;
	document.getElementById("reinicio").disabled = false;
}
function parar () {
	clearInterval(control);
	document.getElementById("parar").disabled = true;
	document.getElementById("continuar").disabled = false;
}
function reinicio () {
	clearInterval(control);
	centesimas = 0;
	segundos = 0;
	minutos = 0;
	horas = 0;
	Centesimas.innerHTML = ":00";
	Segundos.innerHTML = ":00";
	Minutos.innerHTML = ":00";
	Horas.innerHTML = "00";
	document.getElementById("inicio").disabled = false;
	document.getElementById("parar").disabled = true;
	document.getElementById("continuar").disabled = true;
	document.getElementById("reinicio").disabled = true;
}
function cronometro () {
	if (centesimas < 99) {
		centesimas++;
		if (centesimas < 10) { centesimas = "0"+centesimas }
		Centesimas.innerHTML = ":"+centesimas;
	}
	if (centesimas == 99) {
		centesimas = -1;
	}
	if (centesimas == 0) {
		segundos ++;
		if (segundos < 10) { segundos = "0"+segundos }
		Segundos.innerHTML = ":"+segundos;
	}
	if (segundos == 59) {
		segundos = -1;
	}
	if ( (centesimas == 0)&&(segundos == 0) ) {
		minutos++;
		if (minutos < 10) { minutos = "0"+minutos }
		Minutos.innerHTML = ":"+minutos;
	}
	if (minutos == 59) {
		minutos = -1;
	}
	if ( (centesimas == 0)&&(segundos == 0)&&(minutos == 0) ) {
		horas ++;
		if (horas < 10) { horas = "0"+horas }
		Horas.innerHTML = horas;
	}
}
</script>