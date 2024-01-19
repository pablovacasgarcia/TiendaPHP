<?php \Utils\Utils::logeado();?>

<form action="<?= BASE_URL ?>pedido/hacerPedido/" method="POST">

    <label for="nombre">Provincia</label>
    <input type="text" name="data[provincia]" id="provincia" <?php if (isset($datos['provincia'])): ?> value=<?=$datos['provincia']?>  <?php endif;?> required>

    <label for="apellidos">Localidad</label>
    <input type="text" name="data[localidad]" id="localidad" <?php if (isset($datos['localidad'])): ?> value=<?=$datos['localidad']?>  <?php endif;?> required>

    <label for="email">Dirección</label>
    <input type="text" name="data[direccion]" id="direccion" <?php if (isset($datos['direccion'])): ?> value=<?=$datos['direccion']?>  <?php endif;?> required>


    <input type="submit" required>
</form>
