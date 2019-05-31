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
    ['citas/<id:^[0-9]*$>', 'Cita->verCita'],
    ['citas/crear', 'Cita->crearCita'],

    // Crawler
    ['cargar', 'Crawler->crawler'],
    
    // Dashboard
    ['admin', 'Administracion->index'],
    ['admin/citas', 'Administracion->citas'],
    ['admin/clientes', 'Administracion->clientes'],
    ['admin/clientes/<id_cliente:^[0-9]*$>', 'Administracion->clientes_detalle'],
    ['admin/vehiculos', 'Administracion->vehiculos'],

    ['admin/presupuestos/crear/<id_cita:^[0-9]*$>', 'Administracion->crearPresupuesto'],

    // Vehiculo
    ['vehiculos/crear', 'Vehiculo->create'],
];

?>