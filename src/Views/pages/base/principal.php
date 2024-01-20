<script src="<?=BASE_URL?>public/js/index.js"></script>
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
    <section id="banner">
        <div class="banner__header">
            <div class="banner__header__contain">
                <h2 class="banner__header__contain--title">Zarando</h2>
                <p class="banner__header__contain--text">Tienda de moda y accesorios ONLINE</p>
            </div>
        </div>
        <h2>Productos destacados</h2>
        <section id="banner__slider">
            <div class="items">
                <?php foreach ($productos as $key => $value) : ?>
                    <?php if ($value->getBorrado() == 0 && $value->getStock() > 0 && $key<3) : ?>
                        <?php if($key==0):?>
                        <div class=" item active">
                            <img src="<?= BASE_URL . "/subidas/" . $value->getImagen() ?>">
                        </div>
                        <?php endif;?>
                        <?php if($key==1) :?>
                        <div class=" item next">
                            <img src="<?= BASE_URL . "/subidas/" . $value->getImagen() ?>">
                        </div>
                        <?php endif;?>
                        <?php if($key==2):?>
                        <div class="item prev">
                            <img src="<?= BASE_URL . "/subidas/" . $value->getImagen() ?>">
                        </div>
                        <?php endif;?>
                        <div class="button-container">
                            <div class="button"><i class="ri-arrow-left-circle-line"></i></div>
                            <div class="button"><i class="ri-arrow-right-circle-line"></i></div>
                        </div>
                    <?php endif; ?>
                <?php endforeach ?>
            </div>
        </section>
    </section>
    <!--*-*-*-*-*-*-*-*-*-*-*-*-*-* CONTACT *-*-*-*-*-*-*-*-*-*-*-*-*-*-->
    <section id="contact">
        <!--*-*-*-*-*-*-*-*-*-*-*-*-*-* RRSS *-*-*-*-*-*-*-*-*-*-*-*-*-*-->
        <section id="rrss">
            <section class="rrss__galery">
                <div class="rrss__galery__photo"><img class="rrss__galery__photo__img" src="<?= BASE_URL ?>/public/img/social1.jpg" alt="Contenido social"></div>
                <div class="rrss__galery__photo"><img class="rrss__galery__photo__img" src="<?= BASE_URL ?>/public/img/social2.jpg" alt="Contenido social"></div>
                <div class="rrss__galery__photo"><img class="rrss__galery__photo__img" src="<?= BASE_URL ?>/public/img/social3.jpg" alt="Contenido social"></div>
            </section>
            <section class="rrss__content">
                <h2 class="rrss__content--title">siguenos en nuestras redes sociales</h2>
                <div class="rrss__content__social">
                    <a href="facebook.com"><i class="ph-light ph-facebook-logo"></i></a>
                    <a href="instragram.es"><i class="ph-light ph-instagram-logo"></i></a>
                    <a href="twitter.es"><i class="ph-light ph-twitter-logo"></i></a>
                    <a href="youtube.com"><i class="ph-light ph-youtube-logo"></i></a>
                </div>
            </section>
        </section>
        <!--*-*-*-*-*-*-*-*-*-*-*-*-*-* NEWS LETTER *-*-*-*-*-*-*-*-*-*-*-*-*-*-->
        <section id="personal">
            <form action="" method="post">
                <label for="news">
                    <h2>SUSCRIBETE A NUESTRO NEWS LETTER</h2>
                </label>
                <input type="text" name="" id="news">
                <button class="button__purple" type="submit">suscribirse</button>
            </form>
        </section>
    </section>
</section>