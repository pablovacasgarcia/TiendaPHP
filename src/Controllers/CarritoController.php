<?php

namespace Controllers;

use http\Exception\InvalidArgumentException;
use Lib\Pages;
use Models\Producto;
use Utils\Utils;

/**
 * Controlador para gestionar las operaciones del carrito de compras.
 *
 * @package Controllers
 */
class CarritoController
{
    /** @var Pages Instancia de la clase Pages para renderizar páginas. */
    private Pages $pages;

    /**
     * Constructor de la clase CarritoController.
     */
    public function __construct()
    {
        $this->pages = new Pages();
    }

    /**
     * Agrega un producto al carrito de compras.
     *
     * @param int $id Identificador del producto a agregar.
     * @return void
     */
    public function agregar(int $id): void
    {
            if (isset($id)){
                $producto=new Producto();
                $producto->setId($id);
                $datos=$producto->getProducto();

                if (isset($_SESSION['carrito'])){
                    $carrito=$_SESSION['carrito'];

                    if (isset($carrito[$id])){
                        $carrito[$id]['cantidad']++;
                    } else {
                        $carrito[$id]=['cantidad'=>1, 'producto'=>$datos];
                    }

                } else {
                    $carrito[$id]=['cantidad'=>1, 'producto'=>$datos];
                }

                if ($datos->stock>$carrito[$id]['cantidad']) {
                    $_SESSION['carrito']=$carrito;
                }

                header('location: '.BASE_URL.'carrito/verCarrito/');
            }
    }

    /**
     * Muestra la página del carrito de compras.
     *
     * @return void
     */
    public function verCarrito(): void
    {
        if (isset($_SESSION['carrito'])){
            $this->pages->render('carrito/verCarrito', ['carrito'=>$_SESSION['carrito']]);
        } else {
            $this->pages->render('carrito/verCarrito');
        }
    }

    /**
     * Incrementa la cantidad de un producto en el carrito, comprobando su stock.
     *
     * @param int $id Identificador del producto a incrementar.
     * @return void
     */
    public function incrementar(int $id): void
    {

            if ($id){
                if (isset($_SESSION['carrito'])){
                    $producto=new Producto();
                    $producto->setId($id);
                    $datos=$producto->getProducto();
                    $carrito=$_SESSION['carrito'];
                    $carrito[$id]['cantidad']++;
                    if ($datos->stock==0){
                        unset($carrito[$id]);
                    }else if ($datos->stock<$carrito[$id]['cantidad']) {
                        $carrito[$id]['cantidad']=$datos->stock;
                    }
                    $_SESSION['carrito']=$carrito;
                }
            }

        header('location: '.BASE_URL.'carrito/verCarrito/');
    }

    /**
     * Decrementa la cantidad de un producto en el carrito, comprobando su stock.
     *
     * @param int $id Identificador del producto a decrementar.
     * @return void
     */
    public function decrementar(int $id): void
    {
            if ($id){
                if (isset($_SESSION['carrito'])){
                    $producto=new Producto();
                    $producto->setId($id);
                    $datos=$producto->getProducto();
                    $carrito=$_SESSION['carrito'];
                    $carrito[$id]['cantidad']--;
                    if ($carrito[$id]['cantidad']==0){
                        unset($carrito[$id]);
                    } else if ($datos->stock<$carrito[$id]['cantidad']) {
                        $carrito[$id]['cantidad']=$datos->stock;
                    }
                    $_SESSION['carrito']=$carrito;
                }
            }

        header('location: '.BASE_URL.'carrito/verCarrito/');
    }

    /**
     * Elimina un producto del carrito de compras.
     *
     * @param int $id Identificador del producto a eliminar.
     * @return void
     */
    public function eliminar(int $id): void
    {
            if ($id){
                if (isset($_SESSION['carrito'])){
                    $carrito=$_SESSION['carrito'];
                    unset($carrito[$id]);
                    $_SESSION['carrito']=$carrito;
                }
            }

        header('location: '.BASE_URL.'carrito/verCarrito/');
    }
}