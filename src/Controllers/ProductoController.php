<?php

namespace Controllers;

use Lib\Pages;
use Models\Producto;

class ProductoController
{
    private Pages $pages;

    /**
     * Constructor de la clase ProductoController.
     *
     * @param Pages $pages Objeto de la clase Pages utilizado para renderizar páginas.
     */
    public function __construct()
    {
        $this->pages = new Pages();
    }

    /**
     * Muestra la página de gestión de productos.
     */
    public function gestionar(): void
    {
        $productos = Producto::getAll();
        $this->pages->render("/producto/gestionar", ["productos" => $productos]);
    }

    /**
     * Crea un nuevo producto.
     */
    public function crearProducto(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['producto'])) {
                $datosProducto = $_POST['producto'];
                $datosProducto['imagen'] = $_FILES['imagen'];
                $producto = new Producto();
                $producto->crearProducto($datosProducto);
                $this->gestionar();
            } else {
                $this->pages->render('/producto/crearProducto');
            }
        } else {
            $this->pages->render('/producto/crearProducto');
        }
    }

    /**
     * Elimina un producto por su ID.
     *
     * @param int $id ID del producto a eliminar.
     */
    public function eliminarProducto(int $id): void
    {
        if (isset($id)) {
            $producto = new Producto();
            $producto->eliminar($id);
        }
        $this->gestionar();
    }

    /**
     * Edita un producto por su ID.
     *
     * @param int $id ID del producto a editar.
     */
    public function editarProducto(int $id): void
    {
        if (isset($id)) {
            $producto = new Producto();
            $producto->setId($id);
            if (isset($_POST['producto'])) {
                $producto->editar($_POST['producto']);
                $this->gestionar();
            } else {
                $datos = $producto->getProducto();
                $this->pages->render('/producto/editarProducto', ['datos' => $datos]);
            }
        }
    }

    /**
     * Muestra la página de detalles de un producto por su ID.
     *
     * @param int $id ID del producto a ver.
     */
    public function ver(int $id): void
    {
        $producto = new Producto();
        $producto->setId($id);
        $datos = $producto->getProducto();
        $this->pages->render('/producto/ver', ['producto' => $datos]);
    }
}
