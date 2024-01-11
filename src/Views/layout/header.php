<?php

use Services\CategoriasService;
$categoriasService = new CategoriasService();
$categorias = $categoriasService->findAll();

$categoriasAdmin = array(
    "gestionCategorias" => "Gestion de categorias",
    "gestionProductos" => "Gestion de productos"
);

?>

<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Zarando</title>
        <link rel="stylesheet" href="<?=BASE_URL?>public/css/style.css">
        <script src="https://cdn.jsdelivr.net/npm/vue@3/dist/vue.global.prod.js"></script>
    </head>
    <body>
         
    <header>
        <a href="<?=BASE_URL?>"><h1>Zarando</h1></a>
        <div id="user">
        <?php
            if(!isset($_SESSION['identity'])):?>
                <form action="<?= BASE_URL?>login" method="post" class="container">
                    <button type="submit" name="login" class="log">Log in</button>
                    <button type="submit" name="register" class="reg">Sign up</button>
                </form>
        <?php elseif(isset($_SESSION['identity'])):?>
           
                <p>Hola <?=$_SESSION['identity']['nombre']?></p>
                <form action="<?= BASE_URL?>logout" method="post" class="container">
                    <button type="submit" name="login" class="log">Log out</button>
                </form>
            
        <?php endif;?>
        <a href="<?=BASE_URL?>carrito">CARRITO</a>
        </div>
        <?php if(isset($categorias)):?>
            <nav>
                <?php foreach ($categorias as $key => $categoria): ?>
                    <a href="<?=BASE_URL?>c?id=<?= $categoria->getId()?>"><?= $categoria->getNombre()?></a>
                <?php endforeach;?>
                <a href="<?=BASE_URL?>mis_pedidos">Mis pedidos</a>
            </nav>
        <?php endif;?>
        <?php if(isset($_SESSION['identity']) && $_SESSION['identity']['rol']=='admin'):?>
            <nav id="admin">
            <?php foreach ($categoriasAdmin as $key => $value): ?>
                    <a href="<?=BASE_URL?><?=$key?>"><?= $value?></a>
                <?php endforeach;?>
            </nav>
        <?php endif;?>
    </header>
    <main>