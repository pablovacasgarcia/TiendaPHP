<?php

namespace Models;
use PDO;
use PDOException;
use Lib\BaseDatos;

/**
 * Clase Categoria que representa una categoría de productos.
 *
 * @package Models
 */
class Categoria
{
    /** @var int|null Identificador de la categoría. */
    private $id;

    /** @var string|null Nombre de la categoría. */
    private $nombre;

    /** @var BaseDatos Instancia de la clase BaseDatos para interactuar con la base de datos. */
    private BaseDatos $db;

    /**
     * Constructor de la clase Categoria.
     */
    public function __construct()
    {
        $this->db = new BaseDatos();
    }

    /**
     * Obtiene el identificador de la categoría.
     *
     * @return int|null Identificador de la categoría.
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Establece el identificador de la categoría.
     *
     * @param int|null $id Identificador de la categoría.
     */
    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    /**
     * Obtiene el nombre de la categoría.
     *
     * @return string|null Nombre de la categoría.
     */
    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    /**
     * Establece el nombre de la categoría.
     *
     * @param string|null $nombre Nombre de la categoría.
     */
    public function setNombre(?string $nombre): void
    {
        $this->nombre = $nombre;
    }

    /**
     * Obtiene todas las categorías almacenadas en la base de datos.
     *
     * @return array|false Arreglo de categorías o false en caso de error.
     */
    public static function getAll(): false|array
    {
        try {
            $categoria = new Categoria();
            $categoria->db->consulta("SELECT * FROM categorias");
            $categorias = $categoria->db->extraer_todos();
            $categoria->db->close();
        } catch (PDOException $err){
            $categorias=false;
        }

        return $categorias;
    }

    /**
     * Crea una nueva categoría con el nombre proporcionado.
     *
     * @param string $nombre Nombre de la nueva categoría.
     * @return bool true si la categoría se crea con éxito, false en caso contrario.
     */
    public function crearCategoria(string $nombre): bool
    {
        try {
            $stmt=$this->db->prepara('SELECT * FROM categorias where nombre=:nombre');
            $stmt->bindValue(':nombre', $nombre, PDO::PARAM_STR);
            $stmt->execute();
            if ($stmt->rowCount()==0){
                $insert=$this->db->prepara('INSERT INTO categorias VALUES(null, :nombre)');
                $insert->bindValue(':nombre', $nombre, PDO::PARAM_STR);
                $insert->execute();
                $insert->closeCursor();
            }

            $stmt->closeCursor();
            $this->db->close();
            $resultado = true;
        } catch (PDOException $err){
            $resultado=false;
        }

        return $resultado;
    }

    /**
     * Elimina una categoría y sus productos asociados.
     *
     * @param int $id Identificador de la categoría a eliminar.
     * @return bool true si la eliminación se realiza con éxito, false en caso contrario.
     */
    public function eliminar(int $id): bool
    {
        try {
            // Inicia la transacción
            $this->db->iniciarTransaccion();

            // Elimina los registros en la tabla que hace referencia a la categoría
            $deletePedidos = $this->db->prepara('DELETE FROM productos WHERE categoria_id = :id');
            $deletePedidos->bindValue(':id', $id, PDO::PARAM_INT);
            $deletePedidos->execute();

            // Elimina la categoría
            $deleteCategoria = $this->db->prepara('DELETE FROM categorias WHERE id = :id');
            $deleteCategoria->bindValue(':id', $id, PDO::PARAM_INT);
            $deleteCategoria->execute();

            // Confirma la transacción
            $this->db->ejecutarTransaccion();

            $resultado = true;
        } catch (PDOException $err) {
            // Si hay algún error, deshace la transacción
            $this->db->deshacerTransaccion();
            $resultado=false;
        }

        return $resultado;
    }

    /**
     * Obtiene todos los productos asociados a una categoría.
     *
     * @param int $id Identificador de la categoría.
     * @return array|false Arreglo de productos asociados a la categoría o false en caso de error.
     */
    public function mostrarProductos(int $id): false|array
    {
        try {
            $select = $this->db->prepara('SELECT * FROM productos WHERE categoria_id=:id');
            $select->bindValue(':id', $id, PDO::PARAM_INT);
            $select->execute();
            if ($select->rowCount()){
                $productos = $select->fetchAll(PDO::FETCH_ASSOC);
            } else {
                $productos=false;
            }

            $this->db->close();
        } catch (PDOException $err) {
            $productos=false;
        }

        return $productos;
    }

    /**
     * Obtiene los detalles de la categoría actual.
     *
     * @return array|false Detalles de la categoría o false en caso de error.
     */
    public function obtenerCategoria(): false|array
    {
        try {
            $consulta = $this->db->prepara('SELECT * FROM categorias where id=:id');
            $consulta->bindValue(':id', $this->id, PDO::PARAM_INT);
            $consulta->execute();
            $categoria = $consulta->fetch();
            $consulta->closeCursor();
            $this->db->close();
        } catch (PDOException $err){
            $categoria=false;
        }

        return $categoria;
    }


    /**
     * Edita la categoría actual con la información proporcionada.
     *
     * @param string $categoria Nuevo nombre de la categoría.
     * @return bool true si la edición se realiza con éxito, false en caso contrario.
     */
    public function editar(string $categoria): bool
    {
        try {
            $update=$this->db->prepara('UPDATE categorias SET nombre=:nombre WHERE id=:id');
            $update->bindValue(':id', $this->id, PDO::PARAM_INT);
            $update->bindValue(':nombre', $categoria, PDO::PARAM_STR);
            $update->execute();
            $update->closeCursor();
            $this->db->close();
            $result=true;
        } catch (PDOException $err){
            $result=false;
        }

        return $result;
    }

}