<section class="principal">
    <?php foreach ($productos as $key => $value) :?>
        <div class="product">
            <div class="product__img">
                <img src="<?=BASE_URL."/subidas/".$value->getImagen()?>" alt="Producto">
            </div>
            <h3><?=$value->getNombre()?></h3>
            <p><?=$value->getDescripcion()?></p>
            <p><?=$value->getPrecio()?>€</p>
            <a href="<?=BASE_URL?>Carrito/push&id=<?=$value->getId()?>">Comprar</a>
        </div>
    <?php endforeach?>
</section>