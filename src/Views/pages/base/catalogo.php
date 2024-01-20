<?php
// how many records should be displayed on a page?
$records_per_page = 3;
// instantiate the pagination object
$pagination = new Zebra_Pagination();
// the number of total records is the number of records in the array
$pagination->records(count($productos));
// records per page
$pagination->records_per_page($records_per_page);
// here's the magic: we need to display *only* the records for the current page
$productos = array_slice(
    $productos,
    (($pagination->get_page() - 1) * $records_per_page),
    $records_per_page
);
?>
<section class="principal">
    <?php foreach ($productos as $key => $value) : ?>
        <?php if ($value->getBorrado() == 0 && $value->getStock() > 0) : ?>
            <div class="catalogo__producto">
                <div class="catalogo__producto__content">
                    <img class="catalogo__producto__content__img" src="<?= BASE_URL . "/subidas/" . $value->getImagen() ?>" alt="Producto">
                </div>
                <h3 class="catalogo__producto__name"><?= $value->getNombre() ?></h3>
                <p><?= $value->getDescripcion() ?></p>
                <p class="catalogo__producto__price"><?= $value->getPrecio() ?>€</p>
                <a class="button__purple" href="<?= BASE_URL ?>push?id=<?= $value->getId() ?>">Comprar</a>
            </div>
        <?php endif; ?>
    <?php endforeach ?>
</section>
<?php
$pagination->render();
?>