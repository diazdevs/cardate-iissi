<?php

$router_urls = [
    // Paginas base
    ['', 'Base->index'],
    ['about', 'Base->about'],
    ['terminos', 'Base->terminos'],
    ['privacidad', 'Base->privacidad'],
    ['contacto', 'Base->contacto'],

    
    // Usuarios
    ['accounts/login', 'Usuario->login'],
    ['accounts/register', 'Usuario->register'],
    ['accounts/logout', 'Usuario->logout'],

    // Citas
    ['citas', 'Cita->citas'],
    ['citas/<id:^[0-9]$>', 'Cita->verCita'],
    ['citas/crear', 'Cita->crearCita'],

    // Crawler
    ['cargar', 'Crawler->crawler'],
    
    // Dashboard
    ['admin', 'Administracion->index'],

    // Vehiculo
    ['vehiculos/crear', 'Vehiculo->create'],

];

?>