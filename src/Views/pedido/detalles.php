<?php \Utils\Utils::logeado();?>

<h2>Resumen del pedido</h2>
<table>
    <tr>
        <th>Producto</th>
        <th>Precio</th>
        <th>Cantidad</th>
    </tr>
        <?php foreach ($pedido as $producto):?>
            <tr>
                <td><?=$producto['producto']?></td>
                <td><?=$producto['precio']?></td>
                <td><?=$producto['unidades']?></td>
            </tr>
        <?php endforeach;?>
</table>
