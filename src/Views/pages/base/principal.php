<section class="principal">
    <?php foreach ($productos as $key => $value) :?>
        <?php if($value->getBorrado() == 0):?>
            <div class="product">
                <div class="product__img">
                    <img src="<?=BASE_URL."/subidas/".$value->getImagen()?>" alt="Producto">
                </div>
                <h3><?=$value->getNombre()?></h3>
                <p><?=$value->getDescripcion()?></p>
                <p><?=$value->getPrecio()?>€</p>
                <a href="<?=BASE_URL?>push?id=<?=$value->getId()?>">Comprar</a>
            </div>
        <?php endif;?>
    <?php endforeach?>
</section>