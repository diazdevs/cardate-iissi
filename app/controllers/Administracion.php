<?php

namespace controllers\administracion;

class Administracion extends \Controller{

    public function __construct(){
        parent::__construct();
        /**
         * @todo check if user is admin
         */
    }

    public function index(){
        $this->render('administracion/index.html');
    }

}