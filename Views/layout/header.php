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
        <link rel="stylesheet" href="<?=BASE_URL?>public/css/header.css">
        <link rel="stylesheet" href="<?=BASE_URL?>public/css/product.css">
        <link rel="stylesheet" href="<?=BASE_URL?>public/css/carrito.css">        
        <link rel="stylesheet" href="<?=BASE_URL?>vendor/stefangabos/zebra_pagination/public/css/zebra_pagination.css">
        <link rel="stylesheet" href="<?=BASE_URL?>public/css/login.css">
        <link rel="stylesheet" href="<?=BASE_URL?>public/css/commit.css">
        <link rel="stylesheet" href="<?=BASE_URL?>public/css/edit.css">
        <link rel="stylesheet" href="<?=BASE_URL?>public/css/footer.css">
        <script src="https://cdn.jsdelivr.net/npm/vue@3/dist/vue.global.prod.js"></script>
    </head>
    <body>
         
    <header>
        <a href="<?=BASE_URL?>Base/showPage"><h1>Zarando</h1></a>
        <div id="user">
        <?php
            if(!isset($_SESSION['identity'])):?>
                <form action="<?= BASE_URL?>Login/login" method="post" class="container">
                    <button type="submit" name="login" class="log">Log in</button>
                    <button type="submit" name="register" class="reg">Sign up</button>
                </form>
        <?php elseif(isset($_SESSION['identity'])):?>
           
                <p>Hola <?=$_SESSION['identity']['nombre']?></p>
                <form action="<?= BASE_URL?>Login/logout" method="post" class="container">
                    <button type="submit" name="login" class="log">Log out</button>
                </form>
            
        <?php endif;?>
        <a href="<?=BASE_URL?>Carrito/index">CARRITO</a>
        </div>
        <?php if(isset($categorias)):?>
            <nav>
                <?php foreach ($categorias as $key => $categoria): ?>
                    <a href="<?=BASE_URL?>Base/ver&id=<?= $categoria->getId()?>"><?= $categoria->getNombre()?></a>
                <?php endforeach;?>
                <a href="">Mis pedidos</a>
            </nav>
        <?php endif;?>
        <?php if(isset($_SESSION['identity']) && $_SESSION['identity']['rol']=='admin'):?>
            <nav id="admin">
            <?php foreach ($categoriasAdmin as $key => $value): ?>
                    <a href="<?=BASE_URL?>Admin/<?=$key?>"><?= $value?></a>
                <?php endforeach;?>
            </nav>
        <?php endif;?>
    </header>
    <main>