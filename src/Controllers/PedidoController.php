<?php

namespace Controllers;

use Lib\Pages;
use Models\Pedido;

/**
 * Controlador para gestionar las operaciones relacionadas con los pedidos de productos.
 *
 * @package Controllers
 */
class PedidoController
{
    /** @var Pages Instancia de la clase Pages para renderizar páginas. */
    private Pages $pages;

    /**
     * Constructor de la clase PedidoController.
     *
     */
    public function __construct()
    {
        $this->pages = new Pages();
    }

    /**
     * Muestra la página de gestión de pedidos con la lista de pedidos disponibles.
     *
     * @return void
     */
    public function gestionar(): void
    {
        $pedidos=Pedido::getAll();

        $this->pages->render("/pedido/gestionar", ["pedidos"=>$pedidos]);
    }

    /**
     * Crea un nuevo pedido utilizando los datos del carrito y la información del usuario.
     *
     * @param array $datos Datos del usuario para la dirección de entrega.
     * @return void
     */
    public function crearPedido(array $datos): void
    {
            if (isset($_SESSION['carrito'])){
                $carrito = $_SESSION['carrito'];
                $pedido = new Pedido();
                $pedido->crearPedido($carrito, $datos);
            }
    }

    /**
     * Muestra la página para realizar un nuevo pedido, verificando la autenticación del usuario.
     *
     * @return void
     */
    public function hacerPedido(): void
    {
        if (isset($_SESSION['login'])&&$_SESSION['login']!="failed"){
            if (isset($_POST['data'])){
                $datos = $_POST['data'];
                if ($datos['provincia']!="" && $datos['localidad']!="" && $datos['direccion']!=""){
                    $this->crearPedido($datos);
                    $this->ver();
                } else {
                    $this->pages->render('pedido/hacerPedido');
                }
            } else {
                $this->pages->render('pedido/hacerPedido');
            }
        } else{
            $this->pages->render('usuario/login');
        }
    }

    /**
     * Muestra la página con la lista de pedidos del usuario autenticado.
     *
     * @return void
     */
    public function ver(): void
    {
        if (isset($_SESSION['login']->id)){
            $pedidos=Pedido::getPedidos($_SESSION['login']->id);
        } else {
            $pedidos=[];
        }

        $this->pages->render("/pedido/ver", ["pedidos"=>$pedidos]);
    }

    /**
     * Muestra los detalles de un pedido específico.
     *
     * @param int $id Identificador del pedido.
     * @return void
     */
    public function verDetalles(int $id): void
    {
        $pedido=new Pedido();
        $pedido->setId($id);
        $datos=$pedido->getDetalles();

        $this->pages->render("/pedido/detalles", ["pedido"=>$datos]);
    }

    /**
     * Cambia el estado de un pedido a "Enviado".
     *
     * @param int $id Identificador del pedido.
     * @return void
     */
    public function enviar(int $id): void
    {
        $pedido=new Pedido();
        $pedido->setId($id);
        $pedido->cambiarEstado("Enviado");

        $this->gestionar();
    }

    /**
     * Cambia el estado de un pedido a "Completado".
     *
     * @param int $id Identificador del pedido.
     * @return void
     */
    public function completar(int $id): void
    {
        $pedido=new Pedido();
        $pedido->setId($id);
        $pedido->cambiarEstado("Completado");

        $this->gestionar();
    }

}