<section class="carrito">
    <?php foreach ($productosCarrito as $key => $productoCarrito) :?>
        <?php if($productoCarrito['productos'][0]->getBorrado() == 0) :?>
        <article class="carrito__producto">
            <div class="carrito__producto__info">
                <div class="carrito__producto__content">
                    <img src="<?=BASE_URL."/subidas/".$productoCarrito['productos'][0]->getImagen()?>" alt="Producto" class="carrito__producto__content__img">
                </div>
                <p><?= $productoCarrito['productos'][0]->getNombre()?></p>
            </div>
            <div class="carrito__producto__cantidad">
                <a href="<?=BASE_URL?>down?id=<?=$productoCarrito['id']?>">-</a>
                <p><?= $productoCarrito["unidades"]?></p>
                <a href="<?=BASE_URL?>add?id=<?=$productoCarrito['id']?>">+</a>
            </div>
            <div class="carrito__producto__delete">
                <a href="">Borrar</a>
            </div>
        </article>
        <?php endif;?>
    <?php endforeach;?>
</section>
<?php if(count($_SESSION["carrito"]) >0):?>
    <section>
        <form action="<?=BASE_URL?>pedido" method="POST">
            <button type="submit">Realizar pedido</button>
        </form>
    </section>
<?php else:?>
    <section>
        <h2>Aun no hay ada añadido:</h2>
        <a href="<?=BASE_URL?>">Volver al inicio</a>
    </section>
<?php endif;?>
