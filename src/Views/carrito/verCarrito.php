<?php if (!isset($carrito)):?>
    <p>No hay productos en el carrito</p>
<?php else:?>
    <?php $total=0;?>
    <table>
        <tr>
            <th>Producto</th>
            <th>Cantidad</th>
            <th>Precio</th>
            <th></th>
        </tr>
        <?php foreach($carrito as $id=>$producto):?>
        <tr>
            <td><?=$producto['producto']->nombre;?></td>
            <td>
                <a href="<?=BASE_URL?>carrito/incrementar/<?=$id?>"><button>+</button></a>
                <?=$producto['cantidad'];?>
                <a href="<?=BASE_URL?>carrito/decrementar/<?=$id?>"><button>-</button></a>
            </td>
            <td><?=$producto['producto']->precio*$producto['cantidad'];?>€</td>
            <td><a href="<?=BASE_URL?>carrito/eliminar/<?=$id?>"><button>Eliminar</button></a></td>
        </tr>
        <?php $total+=$producto['producto']->precio*$producto['cantidad'];?>
        <?php endforeach;?>
    </table>
    <h3>
        Total: <?=$total?>€
        <a href="<?=BASE_URL?>pedido/hacerPedido/"><button>Hacer Pedido</button></a>
    </h3>

<?php endif;?>