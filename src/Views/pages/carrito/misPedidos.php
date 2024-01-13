<section class="carrito">
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
            <?php foreach ($detalles as $value) :?>
                <p><?= var_dump($value['producto']->getNombre())?></p>
            <?php endforeach;?>
        <?php endif;?>
    <?php endforeach; ?>
</section>