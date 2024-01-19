<?php

namespace Models;

use Exception;
use Lib\BaseDatos;
use PDO;
use PDOException;
use PHPMailer\PHPMailer\PHPMailer;
use Utils\Utils;
/**
 * Clase Pedido que representa un pedido realizado por un usuario.
 *
 * @package Models
 */
class Pedido
{
    /** @var int Identificador del pedido. */
    private int $id;

    /** @var int Identificador del usuario que realiza el pedido. */
    private int $usuarioId;

    /** @var string Provincia de la dirección de entrega del pedido. */
    private string $provincia;

    /** @var string Localidad de la dirección de entrega del pedido. */
    private string $localidad;

    /** @var string Dirección de entrega del pedido. */
    private string $direccion;

    /** @var int Costo total del pedido. */
    private int $coste;

    /** @var string Estado del pedido. */
    private string $estado;

    /** @var string Fecha en que se realiza el pedido. */
    private string $fecha;

    /** @var string Hora en que se realiza el pedido. */
    private string $hora;

    /** @var BaseDatos Instancia de la clase BaseDatos para interactuar con la base de datos. */
    private BaseDatos $db;

    /**
     * Constructor de la clase Pedido.
     */
    public function __construct()
    {
        $this->db = new BaseDatos();
    }

    /**
     * Obtiene el identificador del pedido.
     *
     * @return int Identificador del pedido.
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Establece el identificador del pedido.
     *
     * @param int $id Identificador del pedido.
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * Obtiene el identificador del usuario que realiza el pedido.
     *
     * @return int Identificador del usuario.
     */
    public function getUsuarioId(): int
    {
        return $this->usuarioId;
    }

    /**
     * Establece el identificador del usuario que realiza el pedido.
     *
     * @param int $usuarioId Identificador del usuario.
     */
    public function setUsuarioId(int $usuarioId): void
    {
        $this->usuarioId = $usuarioId;
    }

    /**
     * Obtiene la provincia de la dirección de entrega del pedido.
     *
     * @return string Provincia de entrega.
     */
    public function getProvincia(): string
    {
        return $this->provincia;
    }

    /**
     * Establece la provincia de la dirección de entrega del pedido.
     *
     * @param string $provincia Provincia de entrega.
     */
    public function setProvincia(string $provincia): void
    {
        $this->provincia = $provincia;
    }

    /**
     * Obtiene la localidad de la dirección de entrega del pedido.
     *
     * @return string Localidad de entrega.
     */
    public function getLocalidad(): string
    {
        return $this->localidad;
    }

    /**
     * Establece la localidad de la dirección de entrega del pedido.
     *
     * @param string $localidad Localidad de entrega.
     */
    public function setLocalidad(string $localidad): void
    {
        $this->localidad = $localidad;
    }

    /**
     * Obtiene la dirección de entrega del pedido.
     *
     * @return string Dirección de entrega.
     */
    public function getDireccion(): string
    {
        return $this->direccion;
    }

    /**
     * Establece la dirección de entrega del pedido.
     *
     * @param string $direccion Dirección de entrega.
     */
    public function setDireccion(string $direccion): void
    {
        $this->direccion = $direccion;
    }

    /**
     * Obtiene el costo total del pedido.
     *
     * @return int Costo total del pedido.
     */
    public function getCoste(): int
    {
        return $this->coste;
    }

    /**
     * Establece el costo total del pedido.
     *
     * @param int $coste Costo total del pedido.
     */
    public function setCoste(int $coste): void
    {
        $this->coste = $coste;
    }

    /**
     * Obtiene el estado del pedido.
     *
     * @return string Estado del pedido.
     */
    public function getEstado(): string
    {
        return $this->estado;
    }

    /**
     * Establece el estado del pedido.
     *
     * @param string $estado Estado del pedido.
     */
    public function setEstado(string $estado): void
    {
        $this->estado = $estado;
    }

    /**
     * Obtiene la fecha en que se realiza el pedido.
     *
     * @return string Fecha del pedido.
     */
    public function getFecha(): string
    {
        return $this->fecha;
    }

    /**
     * Establece la fecha en que se realiza el pedido.
     *
     * @param string $fecha Fecha del pedido.
     */
    public function setFecha(string $fecha): void
    {
        $this->fecha = $fecha;
    }

    /**
     * Obtiene la hora en que se realiza el pedido.
     *
     * @return string Hora del pedido.
     */
    public function getHora(): string
    {
        return $this->hora;
    }

    /**
     * Establece la hora en que se realiza el pedido.
     *
     * @param string $hora Hora del pedido.
     */
    public function setHora(string $hora): void
    {
        $this->hora = $hora;
    }

    /**
     * Obtiene todos los pedidos.
     *
     * @return array Lista de pedidos.
     */
    public static function getAll(): array
    {
        $pedido = new Pedido();
        $pedido->db->consulta("SELECT * FROM pedidos");
        $pedidos = $pedido->db->extraer_todos();
        $pedido->db->close();
        return $pedidos;
    }

    /**
     * Obtiene los pedidos realizados por un usuario específico.
     *
     * @param int $id Identificador del usuario.
     * @return array Lista de pedidos del usuario.
     */
    public static function getPedidos(int $id): array
    {
        $pedido = new Pedido();
        $pedido->db->consulta('SELECT * FROM pedidos WHERE usuario_id=' . $id);
        $pedidos = $pedido->db->extraer_todos();
        $pedido->db->close();
        return $pedidos;
    }

    /**
     * Obtiene los detalles de un pedido.
     *
     * @return array Lista de detalles del pedido.
     */
    public function getDetalles(): array
    {
        $this->db->consulta('SELECT * FROM lineas_pedidos WHERE pedido_id=' . $this->id);
        $detalles = $this->db->extraer_todos();
        $this->db->close();
        return $detalles;
    }

    /**
     * Crea un nuevo pedido en la base de datos.
     *
     * @param array $carrito Carrito de productos.
     * @param array $datos Información del pedido.
     * @return bool true si el pedido se crea con éxito, false en caso contrario.
     */
    public function crearPedido(array $carrito, array $datos): bool
    {
        try {
            $this->db->iniciarTransaccion();

            $total = 0;

            foreach ($carrito as $producto) {
                $total += $producto['cantidad'] * $producto['producto']->precio;
            }

            $insert = $this->db->prepara('INSERT INTO pedidos (usuario_id, provincia, localidad, direccion, coste, estado, fecha, hora) VALUES (:usuario_id, :provincia, :localidad, :direccion, :coste, :estado, current_date, current_time)');
            $insert->bindValue(':usuario_id', $_SESSION['login']->id, PDO::PARAM_INT);
            $insert->bindValue(':provincia', $datos['provincia'], PDO::PARAM_STR);
            $insert->bindValue(':localidad', $datos['localidad'], PDO::PARAM_STR);
            $insert->bindValue(':direccion', $datos['direccion'], PDO::PARAM_STR);
            $insert->bindValue(':coste', $total);
            $insert->bindValue(':estado', "Pagado", PDO::PARAM_STR);

            $insert->execute();
            $insert->closeCursor();

            $id = $this->db->ultimoIdInsertado();

            foreach ($carrito as $producto) {
                $update = $this->db->prepara('INSERT INTO lineas_pedidos (pedido_id, producto, precio, unidades) VALUES (:pedido_id, :producto, :precio, :unidades)');
                $update->bindValue(':pedido_id', $id, PDO::PARAM_INT);
                $update->bindValue(':producto', $producto['producto']->nombre, PDO::PARAM_STR);
                $update->bindValue(':precio', $producto['producto']->precio, PDO::PARAM_STR);
                $update->bindValue(':unidades', $producto['cantidad'], PDO::PARAM_STR);
                $update->execute();
                $update->closeCursor();

                $stmt = $this->db->prepara('UPDATE productos SET stock=:stock WHERE id=:id');
                $stmt->bindValue(':id', $producto['producto']->id, PDO::PARAM_INT);
                $stmt->bindValue(':stock', $producto['producto']->stock - $producto['cantidad'], PDO::PARAM_INT);
                $stmt->execute();
                $stmt->closeCursor();
            }

            $this->enviarCorreo($id, $carrito, $total);

            $this->db->ejecutarTransaccion();
            $resultado = true;
            Utils::deleteSession('carrito');
        } catch (\PDOException $err) {
            $this->db->deshacerTransaccion();
            $resultado = false;
            echo($err);
        }

        return $resultado;
    }

    /**
     * Envía un correo electrónico con los detalles del pedido.
     *
     * @param int $pedidoId Identificador del pedido.
     * @param array $carrito Carrito de productos.
     * @param float $total Costo total del pedido.
     */
    public function enviarCorreo(int $pedidoId, array $carrito, float $total): void
    {
        $usuario=$_SESSION['login']->email;
        $nombre=$_SESSION['login']->nombre;
        $productos="";

        foreach ($carrito as $producto){
            $productos.="<tr><td>".$producto['producto']->nombre."</td><td>".$producto['cantidad']."</td><td>".$producto['producto']->precio."€</td></tr>";
        }

        $mail = new PHPMailer(true);

        try {
            //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = 'xxxxxx@gmail.com';                     //SMTP username
            $mail->Password   = 'xxxxxxxx';                                     //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
            $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS

            //Recipients
            $mail->setFrom('pablovacasgarcia@gmail.com', 'Pablo');
            $mail->addAddress($usuario);     //Add a recipient
            $mail->addReplyTo('pablovacasgarcia@gmail.com', 'Information');

            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = "Su pedido n{$pedidoId}  se ha realizado correctamente!";
            $mail->Body    = "Hola $nombre, estos son los detalles de tu pedido:<br><br>
                <table border='1px solid black' cellpadding='2px' cellspacing='2px'>
                    <tr>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>Precio</th>
                    </tr>
                    $productos
                </table>

                <p>Total: <b>$total €</b></p>";

            $mail->send();
        } catch (Exception $e) {
            echo "Error al enviar el correo: {$mail->ErrorInfo}";
        }

    }

    /**
     * Cambia el estado de un pedido.
     *
     * Este método actualiza el estado de un pedido con el nuevo estado proporcionado.
     *
     * @param string $estado El nuevo estado del pedido.
     * @return bool Devuelve true si el cambio de estado se realiza con éxito, de lo contrario, false.
     * @throws PDOException Si ocurre un error durante la ejecución de la consulta SQL.
     */
    public function cambiarEstado(string $estado): bool
    {
        try {
            $update=$this->db->prepara('UPDATE pedidos SET estado=:estado WHERE id=:id');
            $update->bindValue(':id', $this->id, PDO::PARAM_INT);
            $update->bindValue(':estado', $estado, PDO::PARAM_STR);
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