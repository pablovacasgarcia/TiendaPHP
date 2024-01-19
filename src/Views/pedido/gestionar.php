<?php \Utils\Utils::admin()?>

<h2>Gestionar Pedidos</h2>

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
                <?php if($pedido['estado']=="Pagado"):?>
                    <button><a href="<?=BASE_URL?>pedido/enviar/<?=$pedido['id']?>">Marcar como enviado</a></button>
                <?php elseif($pedido['estado']=="Enviado"):?>
                    <button><a href="<?=BASE_URL?>pedido/completar/<?=$pedido['id']?>">Marcar como completado</a></button>
                <?php endif;?>
            </td>
        </tr>
    <?php endforeach;?>
</table>
<?php else:?>
<p>Aún no hay pedidos</p>
<?php endif;?>
