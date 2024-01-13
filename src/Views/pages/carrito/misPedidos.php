<section class="carrito">
    <?php if(isset($pedidos)) :?>
        <?php foreach ($pedidos as $key => $pedido) : ?>
        <form action="<?=BASE_URL ?>detalle_pedido" method="post">
            <article class="carrito__producto">
                <p>Fecha: <?= $pedido->getFecha() ?> <?= $pedido->getHora() ?></p>
                <p>Precio: <?= $pedido->getCoste() ?> €</p>
                <div>
                    <p>Direccion: <?= $pedido->getDireccion() ?></p>
                    <p>Provincia: <?= $pedido->getProvincia() ?></p>
                </div>
                <p>Estado: <?= $pedido->getEstado() ?></p>
                <button type="submit" name="detalle" value="<?=$pedido->getId()?>">Detalle</button>
            </article>
        </form>
        <?php if(isset($detalles) && $detalles[0]['id_pedido']==$pedido->getId()):?>
            <article class="detalle__producto">
                <div class="detalle__producto--cabecera">
                <h2>Detalles de su pedido:</h2>
                <a href="<?=BASE_URL?>mis_pedidos"><i class="ph-light ph-x"></i></a>
                </div>
                <div>
                    <?php foreach ($detalles as $value) :?>
                        
                        <div class="carrito__producto__info">
                            <div class="carrito__producto__content">
                                <img src="<?=BASE_URL."/subidas/".$value['producto']->getImagen()?>" alt="Producto" class="carrito__producto__content__img">
                            </div>
                            <p><?= $value['producto']->getNombre()?></p>
                        </div>
                    
                    <?php endforeach;?>
                </div>
            </article>
        <?php endif;?>
    <?php endforeach; ?>
    <?php endif;?>
</section>