<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidade">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="Mateus Freitas">
    <meta name="description" 
          content="This Bakery website is a learning project which presents dynamic page content">
    
    <!-- <link rel="preload" href="/fonts/KingThings/kingthings_foundation-webfont.woff2" as="font" type="font/woff2"> -->
    <!-- <link rel="preload" href="/images/icons/McKayIcon.png" as="image" type="image/png"> -->

    <link rel="stylesheet" href="<?= $css ?>">
    <script src="<?= $script ?>" defer type="module"></script>

    <title> <?= $title ?> </title>
</head>

<body>

<?php
    require "header.php";

    require $mainTemplate;

    require "footer.php";
?>

</body>

</html>
