<?php \Utils\Utils::logeado();?>

<h2>Mis Pedidos</h2>

<?php if($pedidos):?>
    <table>
        <tr>
            <th>Id</th>
            <th>Dirección</th>
            <th>Fecha</th>
            <th>Estado</th>
            <th>Acciones</th>
        </tr>
        <?php foreach ($pedidos as $pedido):?>
            <tr>
                <td>
                    <?=$pedido['id']?>
                </td>
                <td>
                    <?=$pedido['direccion']?>
                </td>
                <td>
                    <?=$pedido['fecha']?>
                </td>
                <td>
                    <?=$pedido['estado']?>
                </td>
                <td>
                    <button><a href="<?=BASE_URL?>pedido/verDetalles/<?=$pedido['id']?>">Ver detalles</a></button>
                </td>
            </tr>
        <?php endforeach;?>
    </table>
<?php else:?>
    <p>Aún no hay pedidos</p>
<?php endif;?>
