<?php 

function getSelectCategoriesEditHtml($productId, $defaultCategory, $categories) {
    ob_start();

    echo "<select name=\"category\" id=\"category_$productId\" disabled>";

    foreach ($categories as $category) {
        $categoryName = $category['name'];
        $categoryId = $category['pk_id'];
        if ($defaultCategory == $categoryId) 
            echo "<option value=$categoryId selected>$categoryName</option>";
        else
            echo "<option value=$categoryId>$categoryName</option>";
    }

    echo '</select>';

    return ob_get_clean();
}

function getSelectCategoriesAddHtml($categories) {
    ob_start();

    echo "<select name=\"category\" id=\"category_add\">";

    foreach ($categories as $category) {
        $categoryName = $category['name'];
        $categoryId = $category['pk_id'];
        echo "<option value=$categoryId>$categoryName</option>";
    }

    echo '</select>';

    return ob_get_clean();
}


function getProductsHtml($products, $categories) {
    ob_start();

    foreach ($products as $product) {
        $id = $product['pk_id'];
        $imgUrl = $product['img_url'];
        $name = $product['name'];
        $description = $product['description'];
        $categoryProduct = $product['category'];
        $price = $product['price'];

        $selectCategoriesHtml = getSelectCategoriesEditHtml($id, $categoryProduct, $categories);

        echo <<< _EOF

        <div class="product-stock-card light-card basic-form form-card" data-state='disabled-show' data-id="$id">
            <form action="stock/edit" method="post" enctype="multipart/form-data" class="product-card-info ut-flow">

            <label for="img_$id" class="products-stock-change-image-label loading-wheel-wrapper">
                <img loading="lazy" src="$imgUrl">
            </label>

            <div class="products-stock-change-image">
                <input type="file" name="img" id="img_$id" disabled>
            </div>

                <div>
                    <label for="name_$id">Nome</label>
                    <input type="text" value="$name" name="name" id="name_$id" disabled>
                </div>

                <div>
                    <label for="description">Descrição</label>
                    <textarea name="description" id="description_$id" rows="5" disabled>
        $description
                    </textarea>
                </div>

                <div>
                    <label for="category_$id">Categoria</label>
                    $selectCategoriesHtml
                </div>

                <div>
                    <label for="price">Preço (R$)</label>
                    <input type="number" name="price" id="price_$id" value="$price" min="0" step="0.01" disabled>
                </div>

                <input type="hidden" id="id_$id" name="id" value="$id" disabled>

                <button type="button" class="product-stock-edit button-link">Editar</button>

                <ul class="product-card-submit-actions ut-row ut-flow-row" data-state='disabled'>
                    <button type="submit" name="submit" class="product-stock-confirm button-link">Confirmar</button>
                    <button type="submit" name="delete" class="product-stock-delete button-link">Deletar</button>
                    <button type="reset" class="product-stock-cancel button-link">Cancelar</button>
                </ul>

            </form>
        </div>

        _EOF;

    }

    return ob_get_clean();
}


$productsHtml = getProductsHtml($productsAllItems, $categories);

$categoriesSelectOptions = getSelectCategoriesAddHtml($categories);

?>


<main class="stock-main main-items-page">
    <aside class="aside-nav light-card stock-actions-aside">
        <div id="stock-actions-buttons" class="ut-flow">
            <h2>Ações</h2>
            <ul class="">
                <li><button class="button-link disable-item-button enable-item-button"
                        data-enable-for="stock-add-item-form" data-disable-for="stock-actions-buttons">Adicionar
                        Item</button></li>
                <li><button class="button-link disable-item-button enable-item-button"
                        data-enable-for="stock-add-category-form" data-disable-for="stock-actions-buttons">Adicionar
                        Categoria</button></li>
            </ul>
        </div>

        <form action="stock/add" id="stock-add-item-form" class="form-card basic-form ut-flow" method="post"
            enctype="multipart/form-data" data-state="disabled">
            <div>
                <label for="img_add">Imagem</label>
                <input type="file" name="img" id="img_add">
            </div>

            <div>
                <label for="name_add">Nome</label>
                <input type="text" value="" name="name" id="name_add">
            </div>

            <div>
                <label for="description_add">Descrição</label>
                <textarea name="description" id="description_add" rows="5"></textarea>
            </div>

            <div>
                <label for="category_add">Categoria</label>
                <?= $categoriesSelectOptions ?>
            </div>

            <div>
                <label for="price_add">Preço (R$)</label>
                <input type="number" name="price" id="price_add" value="" min="0" step="0.01">
            </div>

            <div class="ut-flow-row">
                <button name="submit-product" type="submit" class="button-link">Adicionar</button>
                <button type="reset" class="disable-item-button enable-item-button button-link"
                    data-disable-for="stock-add-item-form" data-enable-for="stock-actions-buttons">Cancelar</button>
            </div>

        </form>

        <form action="stock/add" id="stock-add-category-form" class="form-card basic-form ut-flow" method="post"
            enctype="multipart/form-data" data-state="disabled">
            <div>
                <label for="category_name">Nova Categoria</label>
                <input type="text" name="name" id="category_name">
            </div>

            <div>
                <label for="category_img">Imagem Descritiva</label>
                <input type="file" name="img" id="category_img">
            </div>

            <div class="ut-flow-row">
                <button name="submit-category" type="submit" class="button-link">Adicionar</button>
                <button type="reset" class="disable-item-button enable-item-button button-link"
                    data-disable-for="stock-add-category-form" data-enable-for="stock-actions-buttons">Cancelar</button>
            </div>
        </form>
    </aside>
       <button id="hide-menu-type-list" arial-label="hide-aside-actions"></button>

    <article class="menu-list">

        <h1>Produtos</h1>

        <div class="menu-list-items">
            <?= $productsHtml ?>
        </div>
    </article>
</main>
