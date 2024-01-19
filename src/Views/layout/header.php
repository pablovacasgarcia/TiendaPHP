<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tienda de zapatos</title>
    <link rel="stylesheet" href="<?=BASE_URL?>/css/style.css" type="text/css">
</head>
<body>
    <header>
        <h1><a href="<?=BASE_URL?>">Tienda</a></h1>
        <?php if (isset($_SESSION['login']) AND $_SESSION['login']!='failed'):?>
            <h2><?=$_SESSION['login']->nombre?> <?=$_SESSION['login']->apellidos?></h2>
        <?php endif;?>
        <nav>
            <?php if (!isset($_SESSION['login']) OR $_SESSION['login']=='failed'):?>
                <a href="<?=BASE_URL?>usuario/login/">Identificarse</a>
                <a href="<?=BASE_URL?>usuario/registro/">Registrarse</a>
            <?php else:?>
                <?php if ($_SESSION['login']->rol === "admin"): ?>
                    <a href="<?=BASE_URL?>pedido/gestionar/">Gestionar pedidos</a>
                    <a href="<?=BASE_URL?>producto/gestionar/">Gestionar productos</a>
                    <a href="<?=BASE_URL?>categoria/gestionar/">Gestionar categorías</a>
                    <a href="<?=BASE_URL?>usuario/crear/">Registrar usuario</a>
                <?php else:?>
                    <a href="<?=BASE_URL?>pedido/ver/">Mis pedidos</a>
                    <a href="<?=BASE_URL?>carrito/verCarrito/">Carrito</a>
                <?php endif; ?>
                <a href="<?=BASE_URL?>usuario/logout/">Cerrar Sesión</a>
            <?php endif;?>
        </nav>
    </header>

    <?php $categorias = \Controllers\CategoriaController::obtenerCategorias(); ?>

    <nav id="menu">
        <ul>
            <?php foreach ($categorias as $categoria): ?>
                <li>
                    <b><a href="<?=BASE_URL?>categoria/ver/<?=$categoria['id']?>"><?=$categoria['nombre']?></a></b>
                </li>
            <?php endforeach; ?>
        </ul>
    </nav>

