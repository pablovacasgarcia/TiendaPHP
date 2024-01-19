<?php \Utils\Utils::admin()?>

<form method="post" action="<?=BASE_URL?>categoria/editarCategoria/<?=$datos['id']?>">
    <label for="categoria">Nombre</label>
    <input type="text" name="categoria" id="categoria" value="<?=$datos['nombre']?>">
    <input type="submit" value="Enviar">
</form>
