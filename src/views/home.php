<?php

ob_start();

foreach ($categories as $category) {
    $name = $category['name'];
    $imgUrl = $category['img_url'];
    echo <<< HTML

    <div class="loading-wheel-wrapper">
        <div class="pretty-card pretty-card-image">
            <a href="/menu#$name">$name</a>
        </div>
        <img loading="lazy" src="$imgUrl" alt="$name"/> 
    </div>

    HTML;

}

$homeGalleryItemsHtml = ob_get_clean();

?>

<main class="home-main">
    <div class="ut-wrapper">
        <article class="info-card-article">
            <h1>Bem Vindo</h1>
            <div class="info-card-content dark-card">
                <div class="info-card-main">
                    <div class="info-card-picture"> 
                        <img loading="lazy" src="images/cookie/gotas.jpg" alt="Biscuits Basquet"/>
                    </div>
                    <div class="info-card-text">
                        <p>
                        Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut
                        labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. </p>
                        <p>
                        Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut
                        labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et
                        ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.
                        </p>
                        <p>
                        Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut
                        labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et
                        ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.
                        </p>

                        <div class="pretty-card-box-wrapper">
                            <p class="pretty-card pretty-card-light-box">
                                <span>Thank You</span>
                            </p>
                        </div>
                    </div>

                </div>

                <div class="info-card-footer">
                    <div>
                        <img loading="lazy" src="/images/icons/McKayIcon.png">
                    </div>
                    <nav>
                        <ul class="">
                            <li><a href="/">Ache um lugar próximo de você.</a></li>
                            <li><a href="/">Encontre as melhores receitas</a></li>
                            <li><a href="/">Faça seu pedido.</a></li>
                            <li><a href="/">Conheça nossa equipe</a></li>
                            <li><a href="/">Conheça o nosso processo</a></li>
                            <li><a href="/"></a></li>
                        </ul>
                    </nav> 
                </div>
            </div>
        </article>

        <aside class="home-gallery">
            <?= $homeGalleryItemsHtml ?>
        </aside>

    </div>
</main>
