<?php
namespace Routes;

use Lib\Router;

class Routes
{
    public static function index(){
        Router::add('GET', '/', function(){
            return (new \Controllers\DashboardController())->index();
        });
        Router::add('GET', '/error/', function(){
            return (new \Controllers\ErrorController())->error404();
        });
        Router::add('GET', '/usuario/login/', function(){
            return (new \Controllers\UsuarioController())->login();
        });
        Router::add('GET', '/usuario/registro/', function(){
            return (new \Controllers\UsuarioController())->registro();
        });
        Router::add('POST', '/usuario/login/', function(){
            return (new \Controllers\UsuarioController())->login();
        });
        Router::add('POST', '/usuario/registro/', function(){
            return (new \Controllers\UsuarioController())->registro();
        });
        Router::add('GET', '/usuario/crear/', function(){
            return (new \Controllers\UsuarioController())->crear();
        });
        Router::add('POST', '/usuario/crear/', function(){
            return (new \Controllers\UsuarioController())->crear();
        });
        Router::add('GET', '/categoria/ver/:id', function($id){
            return (new \Controllers\CategoriaController())->ver($id);
        });
        Router::add('GET', '/usuario/logout/', function(){
            return (new \Controllers\UsuarioController())->logout();
        });
        Router::add('GET', '/pedido/gestionar/', function(){
            return (new \Controllers\PedidoController())->gestionar();
        });
        Router::add('GET', '/producto/gestionar/', function(){
            return (new \Controllers\ProductoController())->gestionar();
        });
        Router::add('GET', '/categoria/gestionar/', function(){
            return (new \Controllers\CategoriaController())->gestionar();
        });
        Router::add('GET', '/pedido/gestionar/', function(){
            return (new \Controllers\PedidoController())->gestionar();
        });
        Router::add('GET', '/producto/crearProducto/', function(){
            return (new \Controllers\ProductoController())->crearProducto();
        });
        Router::add('GET', '/categoria/crearCategoria/', function(){
            return (new \Controllers\CategoriaController())->crearCategoria();
        });
        Router::add('POST', '/producto/crearProducto/', function(){
            return (new \Controllers\ProductoController())->crearProducto();
        });
        Router::add('POST', '/categoria/crearCategoria/', function(){
            return (new \Controllers\CategoriaController())->crearCategoria();
        });
        Router::add('GET', '/producto/editarProducto/:id', function($id){
            return (new \Controllers\ProductoController())->editarProducto($id);
        });
        Router::add('GET', '/categoria/editarCategoria/:id', function($id){
            return (new \Controllers\CategoriaController())->editarCategoria($id);
        });
        Router::add('POST', '/producto/editarProducto/:id', function($id){
            return (new \Controllers\ProductoController())->editarProducto($id);
        });
        Router::add('POST', '/categoria/editarCategoria/:id', function($id){
            return (new \Controllers\CategoriaController())->editarCategoria($id);
        });
        Router::add('GET', '/producto/eliminarProducto/:id', function($id){
            return (new \Controllers\ProductoController())->eliminarProducto($id);
        });
        Router::add('GET', '/categoria/eliminarCategoria/:id', function($id){
            return (new \Controllers\CategoriaController())->eliminarCategoria($id);
        });
        Router::add('GET', '/carrito/verCarrito/', function(){
            return (new \Controllers\CarritoController())->verCarrito();
        });
        Router::add('GET', '/carrito/incrementar/:id', function($id){
            return (new \Controllers\CarritoController())->incrementar($id);
        });
        Router::add('GET', '/carrito/decrementar/:id', function($id){
            return (new \Controllers\CarritoController())->decrementar($id);
        });
        Router::add('GET', '/carrito/eliminar/:id', function($id){
            return (new \Controllers\CarritoController())->eliminar($id);
        });
        Router::add('GET', '/carrito/agregar/:id', function($id){
            return (new \Controllers\CarritoController())->agregar($id);
        });
        Router::add('GET', '/pedido/crearPedido/', function(){
            return (new \Controllers\PedidoController())->crearPedido();
        });
        Router::add('GET', '/pedido/hacerPedido/', function(){
            return (new \Controllers\PedidoController())->hacerPedido();
        });
        Router::add('POST', '/pedido/hacerPedido/', function(){
            return (new \Controllers\PedidoController())->hacerPedido();
        });
        Router::add('GET', '/producto/ver/:id', function($id){
            return (new \Controllers\ProductoController())->ver($id);
        });
        Router::add('GET', '/pedido/ver/', function(){
            return (new \Controllers\PedidoController())->ver();
        });
        Router::add('GET', '/pedido/verDetalles/:id', function($id){
            return (new \Controllers\PedidoController())->verDetalles($id);
        });
        Router::add('GET', '/pedido/enviar/:id', function($id){
            return (new \Controllers\PedidoController())->enviar($id);
        });
        Router::add('GET', '/pedido/completar/:id', function($id){
            return (new \Controllers\PedidoController())->completar($id);
        });


        \Lib\Router::dispatch();
    }
}