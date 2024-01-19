<?php \Utils\Utils::admin()?>

<h2>Gestionar Productos</h2>
<a href="<?=BASE_URL?>producto/crearProducto/"><button>Crear producto</button></a>

<?php if($productos):?>
<table>
    <tr>
        <th>id</th>
        <th>Nombre</th>
        <th>Acciones</th>
    </tr>
    <?php foreach ($productos as $producto):?>
        <tr>
            <td>
                <?=$producto['id']?>
            </td>
            <td>
                <?=$producto['nombre']?>
            </td>
            <td>
                <button><a href="<?=BASE_URL?>producto/editarProducto/<?=$producto['id']?>">Editar</a></button>
                <button><a href="<?=BASE_URL?>producto/eliminarProducto/<?=$producto['id']?>">Eliminar</a></button>
            </td>
        </tr>
    <?php endforeach;?>
</table>
<?php else:?>
<p>Aún no hay productos</p>
<?php endif;?>
