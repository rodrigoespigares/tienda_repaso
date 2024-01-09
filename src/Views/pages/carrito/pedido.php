<section class="carrito">
    <?php foreach ($carrito as $productoCarrito) :?>
        <article class="carrito__producto">
            <div class="carrito__producto__info">
                <div class="carrito__producto__content">
                    <img src="<?=BASE_URL."/subidas/".unserialize($productoCarrito['producto'])[0]->getImagen()?>" alt="Producto" class="carrito__producto__content__img">
                </div>
                <p><?= unserialize($productoCarrito['producto'])[0]->getNombre()?></p>
            </div>
            <div class="carrito__producto__cantidad">
                <p>Cantidad: </p>
                <p><?= $productoCarrito["unidades"]?></p>
            </div>
        </article>
    <?php endforeach;?>
</section>
<section class="pedido">
    <h2>Hacer el pedido</h2>
    <form action="<?=BASE_URL?>Carrito/pedir" method="post">
        <div>
            <label for="provincia">Provincia</label>
            <input type="text" name="data[provincia]" id="provincia">
        </div>
        <div>
            <label for="localidad">Localidad</label>
            <input type="text" name="data[localidad]" id="localidad">
        </div>
        <div>
            <label for="direccion">Dirección</label>
            <input type="text" name="data[direccion]" id="direccion">
        </div>
        <button type="submit">Realizar pedido</button>
    </form>
</section>