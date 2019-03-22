<?php

$urls = [
    // Paginas base
    ['', 'Base->index'],
    ['about', 'Base->about'],
    ['terminos', 'Base->terminos'],
    ['privacidad', 'Base->privacidad'],
    
    // Usuarios
    ['accounts/login', 'Usuario->login'],
    ['accounts/register', 'Usuario->register'],
    ['accounts/logout', 'Usuario->logout'],

    // Citas
    ['citas', 'Cita->citas'],
    ['citas/<id:^[0-9]$>', 'Cita->verCita'],
    ['citas/crear', 'Cita->crearCita'],

    // Crawler
    ['cargar', 'Crawler->do'],
    
    // Dashboard
    ['administracion', 'Administracion->index'],

    // Vehiculo
    ['vehiculos/crear', 'Vehiculo->create'],


];

define('URLS', $urls);

?>