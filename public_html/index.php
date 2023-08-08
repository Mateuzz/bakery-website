<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="Mateus Freitas">
    <meta name="description" content="This Bakery website is a learning project
                   which presents dynamic page content">
    <link rel="stylesheet" href="css/styles.css">
    <script src="js/script.js" defer></script>

    <title>Home | McKay's Bakery </title>
</head>

<body>
    <?= require "header.php" ?>

    <main class="home-main">
        <div class="ut-wrapper">
            <article class="info-card-article">
                <h1>Bem Vindo</h1>
                <div class="info-card-content dark-card">
                    <main class="info-card-main">
                        <div class="info-card-picture"> 
                            <img src="images/cookie/gotas.jpg" alt="Biscuits Basquet"/>
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

                    </main>

                    <footer class="info-card-footer">
                        <div>
                            <img src="images/icons/McKayIcon.png">
                        </div>
                        <nav>
                            <ul class="">
                                <li><a href="#">Find a Location Near You</a></li>
                                <li><a href="#">Find a Location Near You</a></li>
                                <li><a href="#">Find a Location Near You</a></li>
                                <li><a href="#">Find a Location Near You</a></li>
                                <li><a href="#">Find a Location Near You</a></li>
                                <li><a href="#">Find a Location Near You</a></li>
                            </ul>
                        </nav> 
                    </footer>
                </div>
            </article>

            <aside class="home-gallery">
                <div>
                    <div class="pretty-card pretty-card-image">
                        <a href="#">Pães</a>
                    </div>
                    <img src="images/bread/boule.jpg" alt=""/> 
                </div>
                <div>
                    <div class="pretty-card pretty-card-image">
                        <a href="#">Doces</a>
                    </div>
                    <img src="images/pastry/bolinhos.jpg" alt=""/> 
                </div>
                <div>
                    <div class="pretty-card pretty-card-image">
                        <a href="#">Pastelaria</a>
                    </div>
                    <img src="images/pastry/diverso.jpg" alt=""/> 
                </div>
                <div>
                    <div class="pretty-card pretty-card-image">
                        <a href="#">Biscoitos</a>
                    </div>
                    <img src="images/cookie/diverso.jpg" alt=""/> 
                </div>
                <div>
                    <div class="pretty-card pretty-card-image">
                        <a href="#">Bolos</a>
                    </div>
                    <img src="images/pastry/torta.jpg" alt=""/> 
                </div>
            </aside>

        </div>
    </main>

    <?= require "footer.php" ?>

</body>

</html>
