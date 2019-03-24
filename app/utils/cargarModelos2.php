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
    $marcas = $crawler->filter('.cat_items > ul > li > a')->each(function(Crawler $node, $i){
        // if (!empty(trim($node->text()))){
            return (object)[
                'marca' => $node->text(),
                'href' => $node->extract(['href'])[0],
            ];
        // }
    });
    return $marcas;
}

foreach(getMarcas() as $marca){
    echo "<a href='$marca->href'>$marca->marca</a><br>";
}