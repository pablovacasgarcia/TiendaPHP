<?php

namespace Controllers;
use Lib\Pages;

class ErrorController
{
    private Pages $pages;

    function __construct(){
        $this->pages = new Pages();
    }

    public function error404(){
        $this->pages->render('error/error', ['titulo' => 'Página no encontrada']);
    }
}