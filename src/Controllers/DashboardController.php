<?php

namespace Controllers;
use Lib\Pages;
use Models\Producto;

class DashboardController
{
    private Pages $pages;
    function __construct(){
        $this->pages = new Pages();
    }
    public function index():void{
        $productos=Producto::obtenerProductosAleatorios();
        $this->pages->render('dashboard/index', ['productos'=>$productos]);
}
}