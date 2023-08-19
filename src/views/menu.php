<?php 

ob_start();

function getCategoriesUl($categories) {
    ob_start();

    echo "<ul class=\"ut-row-nav\">\n";
    foreach ($categories as $category) {
        $id = $category['pk_id'];
        $name = $category['name'];
        echo "<li><a href=\"#$name\" class=\"button-link menu-select-category\" data-category-id=\"$id\">$name</a></li>\n";
    }
    echo "</ut>\n";

    return ob_get_clean();
}

foreach ($menuAllItems as $product) {
    $id = $product['pk_id'];
    $imgUrl = $product['img_url'];
    $name = $product['name'];
    $description = $product['description'];
    $price = $product['price'];
    $stock = $product['stock'];
    $categoryId = $product['category'];

    echo<<<HTML

    <div class="product-menu-card light-card ut-flow" data-category-id="$categoryId" data-state="disabled">
        <div class="loading-wheel-wrapper" data-onload="make-bg-widescreen">
            <img loading="lazy" src="$imgUrl" height="300px" width="100%" style="object-fit: cover">
        </div>
           <div class="product-card-info ut-flow">
               <div class="product-card-title ut-space-between">
                   <h2>$name</h2>
                   <span>R\$$price</span>
               </div>
               <p>$description</p>
           </div>

           <form action="/cart" method="post" class="ut-row ut-flow-row">
               <button type="submit" class="button-link">Comprar</button>
                <label for="qtd-$id">Quantidade</label>
               <input type="number" value="1" min="1" name="add-item-qtd" id="qtd_$id"/> 
               <input type="hidden" value="$id" name="add-item-id">
           </form>
    </div>

    HTML;
}

$menuItemsHtml = ob_get_clean();
$categoriesUlHtml = getCategoriesUl($categories);

 ?>

<main class="menu-main ut-wrapper">
   <nav class="menu-categories-nav light-card" aria-label="menu-categories-filter">
        <?= $categoriesUlHtml ?>
   </nav> 

   <article class="menu-list">
       <h1>Faça seu Pedido</h1>

       <section class="menu-list-items">
            <?= $menuItemsHtml ?>
       </section>
   </article>
</main>
