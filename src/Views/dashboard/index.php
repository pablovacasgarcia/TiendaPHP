<h3>
    Gracias por volver a visitarnos
</h3>
<ul class="productos">
    <?php foreach ($productos as $producto):?>
        <a href="<?=BASE_URL?>producto/ver/<?=$producto['id']?>">
            <div class="producto">
                <img src="./img/<?=$producto['imagen']?>" alt="<?=$producto['imagen']?>">
                <h3><?=$producto['nombre']?> <?=$producto['precio']?>€</h3>
                <a href="<?=BASE_URL?>carrito/agregar/<?=$producto['id']?>"><button>Añadir al carrito</button></a>
            </div>
        </a>
    <?php endforeach;?>
</ul>
