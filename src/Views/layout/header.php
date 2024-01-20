<?php

use Services\CategoriasService;

$categoriasService = new CategoriasService();
$categorias = $categoriasService->findAll();

$categoriasAdmin = array(
    "gestionCategorias" => "Gestión de categorias",
    "gestionProductos" => "Gestión de productos",
    "gestionPedidos" => "Gestión de pedidos",
    "gestionUsuarios" => "Gestión de usuarios",
);

?>

<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zarando</title>
    <link rel="shortcut icon" href="<?=BASE_URL?>public/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="<?= BASE_URL ?>public/css/style.css">
    <!--*-*-*-*-*-*-*-*-*-*-*-*-*-* CDN *-*-*-*-*-*-*-*-*-*-*-*-*-*-->
    <script src="https://unpkg.com/vue@3/dist/vue.global.js"></script> <!-- VUE JS -->
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.6.0/fonts/remixicon.css" rel="stylesheet"> <!-- Iconos remix icon -->
    <script src="https://kit.fontawesome.com/e161f36ce9.js" crossorigin="anonymous"></script> <!-- Iconos fontawesome -->
    <script src="https://unpkg.com/@phosphor-icons/web"></script> <!-- Iconos ed phosphor icon -->
</head>

<body>


    <header>
        <div class="header__logo">
            <a href="<?= BASE_URL ?>" class="header__logo">
                <h1>Zarando</h1>
            </a>
        </div>
        <nav class="top-nav header__nav">
            <input id="menu-toggle" type="checkbox" v-model="check" />
            <label class='menu-button-container' for="menu-toggle">
                <div class='menu-button'></div>
            </label>
            <ul class="menu">
                <?php foreach ($categorias as $key => $categoria) : ?>
                    <?php if ($categoria->getBorrado() == 0) : ?>
                        <li class="header__nav__container"><a href="#" class="header__nav__container__link"><a href="<?= BASE_URL ?>c?id=<?= $categoria->getId() ?>"><?= $categoria->getNombre() ?></a></a></li>
                    <?php endif; ?>
                <?php endforeach; ?>
                <?php if (isset($_SESSION['identity'])) : ?>
                    <li class="header__nav__container"><a href="<?= BASE_URL ?>mis_pedidos">Mis pedidos</a></li>
                <?php endif; ?>
            </ul>
        </nav>
        <?php if (isset($_SESSION['identity']) && $_SESSION['identity']['rol'] == 'admin') : ?>
            <nav id="admin">
                <?php foreach ($categoriasAdmin as $key => $value) : ?>
                    <a href="<?= BASE_URL ?><?= $key ?>" class="admin__item"><?= $value ?></a>
                <?php endforeach; ?>
            </nav>
        <?php endif; ?>
        <div class="header__userInteraction">
            <div class="header__userInteraction__container">
                <?php
                if (!isset($_SESSION['identity'])) : ?>
                    <form action="<?= BASE_URL ?>login" method="post" class="container">
                        <button type="submit" name="login" class="header__userInteraction__container__login" id="login">Iniciar Sesión</button>
                        <button type="submit" name="register" class="header__userInteraction__container__register" id="register">Registrarse</button>
                    </form>
                <?php elseif (isset($_SESSION['identity'])) : ?>

                    <p>Hola <?= $_SESSION['identity']['nombre'] ?></p>
                    <form action="<?= BASE_URL ?>logout" method="post" class="container">
                        <button type="submit" name="login" class="header__userInteraction__container__login">Log out</button>
                    </form>

                <?php endif; ?>
            </div>
            <a href="<?= BASE_URL ?>carrito" class="header__userInteraction__shop"><i class="ph ph-shopping-cart-simple"></i></a>
        </div>
        
    </header>
    <main>