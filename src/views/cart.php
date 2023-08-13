<?php

ob_start();

foreach ($cart_items as $cartItem) {
    $data = $cartItem['data'];
    $qtd = $cartItem['qtd'];
    $totalPrice = $data['price'] * $qtd;
    $totalPrice = sprintf("%.2f", $totalPrice);

    echo <<< _EOF

    <div class="cart-item-card">
        <div> <a href="/cart?remove-item-id={$data['pk_id']}" class="remove" aria-label="remove-cart-item">X</a> </div>
        <div class="cart-item">
            <div class="cart-item-figure loading-wheel-wrapper">
                <img loading="lazy" class="ut-widescreen-img" src="{$data['img_url']}" alt="{$data['name']}" />
            </div>

            <div class="cart-item-info">
                <div class="cart-item-description">
                    <h2>{$data['name']}</h2>
                    <p>{$data['description']}</p> 
                </div> 

                <div class="cart-item-info-price">
                    <p class="cart-item-info-qtd"> 
                    <span class="cart-item-info-qtd-number">{$qtd}</span>x 
                    <span class="cart-item-unit-price">
                        R\$<span class="cart-item-unit-price-number">{$data['price']}</span>
                    </span>

                    </p>

                    <p class="cart-item-info-total">Total R\$
                        <span class="cart-item-info-total-number">$totalPrice</span>
                    </p>
                </div>
            </div> 
        </div>
    </div>

    _EOF;
}

$cartItemsHtml = ob_get_clean();

?>


<main class="main-cart ut-wrapper">
    <h1>Meu Carrinho</h1>
    <div class="cart">
        <form class="cart-finish-buy form-card ut-flow">
            <h2>Finalizar Compra</h2>
            <div class="cart-form-group">
                <label>Cupom de Desconto</label>
                <div class="cart-form-space">
                    <input type="text" value="" name="" id=""/>
                    <button class="button-link">Aplicar Cupom</button>
                </div>
            </div>

            <div class="cart-form-group">
                <label>Cep</label>
                <div class="cart-form-space">
                    <input type="text" value="" name="" id=""/>
                    <button class="button-link">Calcular Frete</button>
                </div>
            </div>

            <div>
                <h3>Subtotal</h3>
                <p class="cart-finish-subtotal">R$0.00</p>
            </div>

            <div>
                <h3>Cupom de Desconto</h3>
                <p class="cart-finish-discount">R$0.00</p>
            </div>

            <div>
                <h3>Valor Total</h3>
                <p class="cart-finish-total">R$0.00</p>
            </div>

            <div>
                <h3>Parcelamento</h3>
                <p class="cart-finish-installment">Até 12x de R$0.00 sem juros.</p>
            </div>

            <button class="button-link">Continuar</button>
        </form>

        <section class="cart-items">
            <h2>Produtos</h2>
            <?= $cartItemsHtml; ?> 
        </section>
    </div>
</main>
