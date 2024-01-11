<section class="carrito">
    <?php foreach ($pedidos as $key => $pedido) :?>
        <article class="carrito__producto">
            <p>Fecha: <?=$pedido->getFecha()?> <?=$pedido->getHora()?></p>
            <p>Precio: <?=$pedido->getCoste()?> €</p>
            <div>
                <p>Direccion: <?=$pedido->getDireccion()?></p>
                <p>Provincia: <?=$pedido->getProvincia()?></p>
            </div>
            <p>Estado: <?=$pedido->getEstado()?></p>
        </article>
    <?php endforeach;?>
</section>