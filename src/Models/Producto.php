<?php

namespace Models;

use Cassandra\Date;
use PDO;
use PDOException;
use Lib\BaseDatos;
/**
 * Clase Producto que representa un producto en la tienda.
 *
 * @package Models
 */
class Producto
{
    /** @var int Identificador del producto. */
    private int $id;

    /** @var int Identificador de la categoría a la que pertenece el producto. */
    private int $categoriaId;

    /** @var string Nombre del producto. */
    private string $nombre;

    /** @var string Descripción del producto. */
    private string $descripcion;

    /** @var float Precio del producto. */
    private float $precio;

    /** @var int Cantidad en stock del producto. */
    private int $stock;

    /** @var string Indicación si el producto está en oferta. */
    private string $oferta;

    /** @var string Fecha de creación del producto. */
    private string $fecha;

    /** @var string Ruta de la imagen del producto. */
    private string $imagen;

    /** @var BaseDatos Instancia de la clase BaseDatos para interactuar con la base de datos. */
    private BaseDatos $db;

    /**
     * Constructor de la clase Producto.
     */
    public function __construct()
    {
        $this->db = new BaseDatos();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getCategoriaId(): int
    {
        return $this->categoriaId;
    }

    public function setCategoriaId(int $categoriaId): void
    {
        $this->categoriaId = $categoriaId;
    }

    public function getNombre(): string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): void
    {
        $this->nombre = $nombre;
    }

    public function getDescripcion(): string
    {
        return $this->descripcion;
    }

    public function setDescripcion(string $descripcion): void
    {
        $this->descripcion = $descripcion;
    }

    public function getPrecio(): float
    {
        return $this->precio;
    }

    public function setPrecio(float $precio): void
    {
        $this->precio = $precio;
    }

    public function getStock(): int
    {
        return $this->stock;
    }

    public function setStock(int $stock): void
    {
        $this->stock = $stock;
    }

    public function getOferta(): string
    {
        return $this->oferta;
    }

    public function setOferta(string $oferta): void
    {
        $this->oferta = $oferta;
    }

    public function getFecha(): string
    {
        return $this->fecha;
    }

    public function setFecha(string $fecha): void
    {
        $this->fecha = $fecha;
    }

    public function getImagen(): string
    {
        return $this->imagen;
    }

    public function setImagen(string $imagen): void
    {
        $this->imagen = $imagen;
    }

    /**
     * Obtiene todos los productos almacenados en la base de datos.
     *
     * @return array|false Arreglo de productos o false en caso de error.
     */
    public static function getAll(): false|array
    {
        $producto = new Producto();
        $producto->db->consulta("SELECT * FROM productos");
        $productos = $producto->db->extraer_todos();
        $producto->db->close();
        return $productos;
    }

    /**
     * Crea un nuevo producto con la información proporcionada.
     *
     * @param array $producto Datos del nuevo producto.
     * @return bool true si la creación se realiza con éxito, false en caso contrario.
     */
    public function crearProducto(array $producto): bool
    {
        try {
            $imagen=$this->nombreFoto($producto['imagen']);
            $this->guardarFoto($imagen, $producto['imagen']);
            $insert=$this->db->prepara('INSERT INTO productos VALUES(null, :categoria_id, :nombre, :descripcion, :precio, :stock, :oferta, current_date, :imagen)');
            $insert->bindValue(':categoria_id', $producto['categoria'], PDO::PARAM_INT);
            $insert->bindValue(':nombre', $producto['nombre'], PDO::PARAM_STR);
            $insert->bindValue(':descripcion', $producto['descripcion'], PDO::PARAM_STR);
            $insert->bindValue(':precio', $producto['precio'], PDO::PARAM_STR);
            $insert->bindValue(':stock', $producto['stock'], PDO::PARAM_INT);
            $insert->bindValue(':oferta', $producto['oferta'], PDO::PARAM_STR);
            $insert->bindValue(':imagen', $imagen, PDO::PARAM_STR);
            $insert->execute();
            $insert->closeCursor();

            $resultado = true;
        } catch (PDOException $err){
            $resultado=false;
        }

        return $resultado;
    }


    /**
     * Función usada para crear un nombre único a cada foto, para no tener fotos duplicadas, haciendo uso de time()
     * @return string Devuelve una cadena con el nombre del nuevo fichero
     */
    function nombreFoto($imagen):string{
        $nombreFichero = $imagen['name'];
        $idUnico = time();
        return $idUnico . "-" . $nombreFichero;
    }

    /**
     * Función que se usa para validar formato y tamaño de una foto y almacenarla en la carpeta img (si no existe se creará)
     * @param string $nombreFichero Cadena con el nombre con el que se guardará la foto
     * @return string Devuelve una cadena con los posibles errores a la hora de guardar la imagen, si no hay, la devuelve vacía
     */
    function guardarFoto(string $nombreFichero, $imagen):string{
        $errores=[];
        $errores['foto']="";
        $nombreDirectorio = "img/";

        $nombreCompleto = $nombreDirectorio . $nombreFichero;
        if (!is_dir('img')) {
            mkdir('img',0755, true);
        }
        if ($imagen['type'] != "image/png" AND $imagen['type'] != "image/jpeg") {
            $errores["foto"] = "Formato incorrecto";
        } elseif ($imagen['size'] > 100000000000) {
            $errores["foto"] = "Tamaño incorrecto";
        } else{
            $mover=move_uploaded_file($imagen["tmp_name"], $nombreCompleto);
            if (!$mover) {
                $errores["foto"] = "No se ha completado la subida.";
            }
        }

        return $errores['foto'];


    }

    /**
     * Elimina un producto por su identificador.
     *
     * @param int $id Identificador del producto a eliminar.
     * @return bool true si la eliminación se realiza con éxito, false en caso contrario.
     */
    public function eliminar(int $id): bool
    {
        try {
            $insert=$this->db->prepara('DELETE FROM productos WHERE id=:id');
            $insert->bindValue(':id', $id, PDO::PARAM_INT);

            $insert->execute();
            $insert->closeCursor();

            $resultado = true;
        } catch (PDOException $err){
            $resultado=false;
        }

        return $resultado;
    }

    /**
     * Obtiene los detalles de un producto por su identificador.
     *
     * @return object|false Detalles del producto o false en caso de error.
     */
    public function getProducto(): object|false
    {
        $id=$this->getId();
        try {
            $consulta=$this->db->prepara('SELECT * FROM productos WHERE id=:id');
            $consulta->bindValue(':id', $id, PDO::PARAM_INT);
            $consulta->execute();

            $resultado=$consulta->fetch(PDO::FETCH_OBJ);
            $consulta->closeCursor();
        } catch (PDOException $err){
            $resultado=false;
        }

        return $resultado;
    }

    /**
     * Edita un producto con la información proporcionada.
     *
     * @param array $producto Datos actualizados del producto.
     * @return bool true si la edición se realiza con éxito, false en caso contrario.
     */
    public function editar(array $producto): bool
    {
        try {
            $update=$this->db->prepara('UPDATE productos SET categoria_id=:categoria_id, nombre=:nombre, descripcion=:descripcion, precio=:precio, stock=:stock, oferta=:oferta WHERE id=:id');
            $update->bindValue(':categoria_id', $producto['categoria'], PDO::PARAM_INT);
            $update->bindValue(':nombre', $producto['nombre'], PDO::PARAM_STR);
            $update->bindValue(':descripcion', $producto['descripcion'], PDO::PARAM_STR);
            $update->bindValue(':precio', $producto['precio'], PDO::PARAM_STR);
            $update->bindValue(':stock', $producto['stock'], PDO::PARAM_INT);
            $update->bindValue(':oferta', $producto['oferta'], PDO::PARAM_STR);
            $update->bindValue(':id', $this->id, PDO::PARAM_STR);
            $update->execute();
            $update->closeCursor();

            $resultado = true;
        } catch (PDOException $err){
            $resultado=false;
        }

        return $resultado;
    }

    /**
     * Obtiene una cantidad específica de productos seleccionados aleatoriamente.
     *
     * @return array|false Arreglo de productos aleatorios o false en caso de error.
     */
    public static function obtenerProductosAleatorios(): false|array
    {
        $producto = new Producto();
        $producto->db->consulta("SELECT * FROM productos ORDER BY RAND() LIMIT 4");
        $productosAleatorios = $producto->db->extraer_todos();
        $producto->db->close();
        return $productosAleatorios;
    }

}