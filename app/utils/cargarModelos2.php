<?php

use Goutte\Client;
use Symfony\Component\DomCrawler\Crawler;

require 'app/models/marca.php';
require 'app/models/modelo.php';
use \models\marca\Marca;
use \models\modelo\Modelo;


/**
 * Araña web https://www.catcar.info/en/
 */


$marcas = array();

echo "<p style='border: 1px solid red;padding:10px;background:#ffc5c5;'>Carga modelos de catcar.info <br> Sustito de app/utils/cargarModelo.php ya que la pagina www.vehiculepartsdatabase.com esta caida</p>";

function getMarcas(){
    $client = new Client();
    $url_marcas = 'https://www.catcar.info/en/';
    $crawler = $client->request('GET', $url_marcas);
    $marcas = $crawler->filter('.link_img')->each(function(Crawler $node, $i){
        // if (!empty(trim($node->text()))){
            return (object)[
                'marca' => $node->extract(['title'])[0],
                'href' => $node->extract(['href'])[0],
            ];
        // }
    });
    return $marcas;
}

function getModelosMarca($marcaUrl) {
    $client = new Client();
    $url_modelos = 'https://www.catcar.info' . $marcaUrl;
    $crawler = $client->request('GET', $url_modelos);
    $modelos = $crawler->filter('tr')->each(function(Crawler $node, $i){
        
        $tablaModelInfo = $node->filter("td")->eq(1);
        $nombre = $tablaModelInfo->extract("_text");
        $href = $tablaModelInfo->filter("a")->eq(0)->extract(['href']);

        if ($nombre && $href){
            return (object)[
                'nombre' => $nombre[0],
                'href' => $href[0]
            ];
        }

    });

    return array_filter($modelos);
}


echo "<h1>Marcas</h1>";
$marcas = getMarcas();
foreach($marcas as $marca){
    echo "<a href='$marca->href'>$marca->marca</a><br>";
}

echo "<h1>Modelos</h1>";
$modelos = getModelosMarca($marcas[0]->href);
foreach($modelos as $modelo){
    echo "<a href='$modelo->href'>Modelo: $modelo->nombre</a><br>";
}


