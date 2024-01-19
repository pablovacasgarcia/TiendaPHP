<div class="detalles">
    <div>
        <img src="../../public/img/<?=$producto->imagen?>" alt="<?=$producto->imagen?>">
    </div>
    <div>
        <h2><?=$producto->nombre?> <?=$producto->precio?>€</h2>
        <p><?=$producto->descripcion?></p>
        <a href="<?=BASE_URL?>carrito/agregar/<?=$producto->id?>"><button>Añadir al carrito</button></a>
    </div>

</div>
