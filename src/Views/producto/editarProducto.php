<?php \Utils\Utils::admin()?>

<form method="post" action="<?=BASE_URL?>producto/editarProducto/<?=$datos->id?>" enctype="multipart/form-data">
    <label for="nombre">Nombre</label>
    <input type="text" name="producto[nombre]" id="nombre" value="<?=$datos->nombre?>">
    <label for="descripcion">Descripción</label>
    <textarea name="producto[descripcion]" id="descripcion"><?=$datos->descripcion?></textarea>
    <label for="precio">Precio</label>
    <input type="number" name="producto[precio]" id="precio" value="<?=$datos->precio?>">
    <label for="Stock">Stock</label>
    <input type="number" name="producto[stock]" id="Stock" value="<?=$datos->stock?>">
    <label for="Oferta">Oferta</label>
    <input type="text" name="producto[oferta]" id="Oferta" value="<?=$datos->oferta?>">
    <label for="categoria">Categoría</label>
    <select name="producto[categoria]" id="categoria">
        <?php foreach ($categorias as $categoria): ?>
            <option value="<?=$categoria['id']?>" <?=$datos->categoria_id==$categoria['id'] ? "selected" : ""?>><?=$categoria['nombre']?></option>
        <?php endforeach;?>
    </select>
    <input type="submit" value="Enviar">
</form>
