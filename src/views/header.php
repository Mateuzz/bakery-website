<?php

ob_start();

if ($isAdmin) {
    echo <<< HTML
        <li><a href="/admin/stock">Admin</a></li>
    HTML;
}

$adminLink = ob_get_clean();

?>

<header class="header">
        <div class="header-span"> </div>
        <div class="header-nav-wrapper">
            <nav class="main-nav ut-wrapper">
                <ul class="ut-row-nav">
                    <li><a href="/">Inicio</a></li>
                    <li><a href="/about">Sobre</a></li>
                    <li><a href="/menu">Menu</a></li>
                    <li><a href="/" class="header-logo"><img src="/images/icons/McKayIcon.png" alt="McKayLogo" width="200px"></a> </li>
                    <li><a href="/user/login">Usuário</a></li>
                    <li><a href="/cart">Carrinho</a></li>
                    <li><a href="/contact">Contato</a></li>
                    <?= $adminLink ?>
                </ul>
            </nav>
        </div>
</header>

