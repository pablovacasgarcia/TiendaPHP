<?php

namespace Controllers;
use Utils\Utils;
namespace Controllers;

use Lib\Pages;
use Models\Categoria;

/**
 * Controlador para gestionar las operaciones relacionadas con las categorías de productos.
 *
 * @package Controllers
 */
class CategoriaController
{
    /** @var Pages Instancia de la clase Pages para renderizar páginas. */
    private Pages $pages;

    /**
     * Constructor de la clase CategoriaController.
     */
    public function __construct()
    {
        $this->pages = new Pages();
    }

    /**
     * Obtiene todas las categorías disponibles.
     *
     * @return array|false Arreglo de categorías o false si hay un error.
     */
    public static function obtenerCategorias(): false|array
    {
        return Categoria::getAll();
    }

    /**
     * Muestra la página de gestión de categorías con la lista de categorías disponibles.
     *
     * @return void
     */
    public function gestionar(): void
    {
        $categorias=Categoria::getAll();

        $this->pages->render("/categoria/gestionar", ["categorias"=>$categorias]);
    }

    /**
     * Crea una nueva categoría utilizando los datos proporcionados en el formulario.
     *
     * @return void
     */
    public function crearCategoria(): void
    {
        if (($_SERVER['REQUEST_METHOD']) === 'POST'){
            if (isset($_POST['categoria']) && $_POST['categoria']!=""){
                $datosCategoria=$_POST['categoria'];
                $categoria = new Categoria();
                $categoria->crearCategoria($datosCategoria);
                $this->gestionar();
            } else {
                $this->pages->render('/categoria/crearCategoria');
            }
        } else {
            $this->pages->render('/categoria/crearCategoria');
        }


    }

    /**
     * Elimina una categoría según el ID proporcionado.
     *
     * @param int $id Identificador de la categoría a eliminar.
     * @return void
     */
    public function eliminarCategoria(int $id): void
    {
            if (isset($id) && $id!="") {
                $categoria=new Categoria();
                $categoria->eliminar($id);

            }
        $this->gestionar();
    }

    /**
     * Muestra la página que presenta los productos asociados a una categoría específica.
     *
     * @param int $id Identificador de la categoría.
     * @return void
     */
    public function ver(int $id): void
    {
            if (isset($id) && $id!="") {
                $categoria=new Categoria();
                $productos=$categoria->mostrarProductos($id);
                $this->pages->render('/categoria/verCategoria', ['productos'=>$productos]);
            }
    }

    /**
     * Muestra la página de edición de una categoría.
     *
     * @param int $id Identificador de la categoría a editar.
     * @return void
     */
    public function editarCategoria(int $id): void
    {
        if (isset($id)){
            $categoria=new Categoria();
            $categoria->setId($id);
            if (isset($_POST['categoria'])){
                $categoria->editar($_POST['categoria']);
                $this->gestionar();
            } else {
                $datos=$categoria->obtenerCategoria();
                $this->pages->render('/categoria/editarCategoria', ['datos'=>$datos]);
            }
        }
    }
}