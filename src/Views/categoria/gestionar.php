<?php \Utils\Utils::admin()?>

<h2>Gestionar Categorías</h2>
<a href="<?=BASE_URL?>categoria/crearCategoria/"><button>Crear categoría</button></a>

<table>
    <tr>
        <th>id</th>
        <th>Nombre</th>
        <th>Gestionar</th>
    </tr>
    <?php foreach ($categorias as $categoria):?>
        <tr>
            <td>
                <?=$categoria['id']?>
            </td>
            <td>
                <?=$categoria['nombre']?>
            </td>
            <td>
                <button><a href="<?=BASE_URL?>categoria/editarCategoria/<?=$categoria['id']?>">Editar</a></button>
                <button><a href="<?=BASE_URL?>categoria/eliminarCategoria/<?=$categoria['id']?>">Eliminar</a></button>
            </td>
        </tr>
    <?php endforeach;?>
</table>


