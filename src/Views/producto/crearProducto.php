<?php \Utils\Utils::admin()?>

<form method="post" action="<?=BASE_URL?>producto/crearProducto/" enctype="multipart/form-data">
    <label for="nombre">Nombre</label>
    <input type="text" name="producto[nombre]" id="nombre" required>
    <label for="descripcion">Descripción</label>
    <textarea name="producto[descripcion]" id="descripcion"></textarea required>
    <label for="precio">Precio</label>
    <input type="number" name="producto[precio]" id="precio" required>
    <label for="Stock">Stock</label>
    <input type="number" name="producto[stock]" id="Stock" required>
    <label for="Oferta">Oferta</label>
    <input type="text" name="producto[oferta]" id="Oferta">
    <label for="categoria">Categoría</label>
    <select name="producto[categoria]" id="categoria" required>
        <?php foreach ($categorias as $categoria): ?>
            <option value="<?=$categoria['id']?>"><?=$categoria['nombre']?></option>
        <?php endforeach;?>
    </select>
    <label for="Imagen">Imagen</label>
    <input type="file" name="imagen" id="Imagen" required>
    <input type="submit" value="Enviar">
</form>
