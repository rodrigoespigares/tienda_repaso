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
<section id="main__index">
<section id="hero">
    <div class="slider">
        <div class="slider__inner">
            <article class="slider__item slider__1">
                <div class="hero__info">
                    <h2 class="hero__info__title">Temporada invierno 23-24</h2>
                    <p class="hero__info__p">Lorem ipsum dolor sit amet consectetur adipisicing elit. Nesciunt, distinctio! Accusamus tempore tempora, quis cum beatae nulla dolore, voluptatem dolorem et libero quaerat, quod velit non nisi ea. Temporibus delectus quos libero iure incidunt eos. Molestias nemo autem numquam, odit asperiores voluptatibus quidem illo ipsum iure similique dolore, iste alias!</p>
                </div>
            </article>
            <article class="slider__item slider__2">
                <div class="hero__info">
                    <h2 class="hero__info__title">Rebajas Enero</h2>
                    <p class="hero__info__p">Lorem ipsum dolor sit amet consectetur adipisicing elit. Nesciunt, distinctio! Accusamus tempore tempora, quis cum beatae nulla dolore, voluptatem dolorem et libero quaerat, quod velit non nisi ea. Temporibus delectus quos libero iure incidunt eos. Molestias nemo autem numquam, odit asperiores voluptatibus quidem illo ipsum iure similique dolore, iste alias!</p>
                </div>
            </article>
            <article class="slider__item slider__3">
                <div class="hero__info">
                    <h2 class="hero__info__title">Ofertas de navidad</h2>
                    <p class="hero__info__p">Lorem ipsum dolor sit amet consectetur adipisicing elit. Nesciunt, distinctio! Accusamus tempore tempora, quis cum beatae nulla dolore, voluptatem dolorem et libero quaerat, quod velit non nisi ea. Temporibus delectus quos libero iure incidunt eos. Molestias nemo autem numquam, odit asperiores voluptatibus quidem illo ipsum iure similique dolore, iste alias!</p>
                </div>
            </article>
            <article class="slider__item slider__4">
                <div class="hero__info">
                    <h2 class="hero__info__title">Fiesta de año nuevo</h2>
                    <p class="hero__info__p">Lorem ipsum dolor sit amet consectetur adipisicing elit. Nesciunt, distinctio! Accusamus tempore tempora, quis cum beatae nulla dolore, voluptatem dolorem et libero quaerat, quod velit non nisi ea. Temporibus delectus quos libero iure incidunt eos. Molestias nemo autem numquam, odit asperiores voluptatibus quidem illo ipsum iure similique dolore, iste alias!</p>
                </div>
            </article>
        </div>
    </div>
</section>
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
</section>