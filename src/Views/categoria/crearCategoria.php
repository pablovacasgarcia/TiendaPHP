<?php \Utils\Utils::admin()?>

<form method="post" action="<?=BASE_URL?>categoria/crearCategoria/">
    <label for="categoria">Nombre</label>
    <input type="text" name="categoria" id="categoria" required>
    <input type="submit" value="Enviar">
</form>
