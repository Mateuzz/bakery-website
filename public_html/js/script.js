function $(selector) {
    return document.querySelector(selector)
}

function $all(selector) {
    return document.querySelectorAll(selector)
}

function enable(item) {
    item.setAttribute('data-state', 'enabled')
}

function disable(item) {
    item.setAttribute('data-state', 'disabled')
}

function getUrlAnchor() {
    const anchor = document.location.hash
    return anchor.replace(/\?.*/, "")
}

/* ************************************/
/*             Menu Page              */
/***************************************/

function menuPage() {
    function filterProductsByCategory(id) {
        for (const product of products) {
            const productId = product.getAttribute('data-category-id')
            if (productId == id) {
                enable(product)
            } else {
                disable(product)
            }
        }
    }

    const menuSelectCategoryButtons = $all('.menu-select-category')

    const products = $all('.product-menu-card')
    const anchor = getUrlAnchor()

    for (const button of menuSelectCategoryButtons) {
        // if is empty will go in the first button
        if (button.href.includes(anchor)) {
            const buttonCategoryId = button.getAttribute('data-category-id')
            filterProductsByCategory(buttonCategoryId)
            break
        }
    }

    menuSelectCategoryButtons.forEach(button => {
        button.onclick = () => {
            const buttonCategoryId = button.getAttribute('data-category-id')
            filterProductsByCategory(buttonCategoryId)
        }
    })
}

/* ************************************/
/*             Cart Page              */
/***************************************/

function cartPage() {
    const cartItemsSection = $('.cart-items')

    if (!cartItemsSection)
        return

    const allCartItems = $all('.cart-item')
    const subtotal = $('.cart-finish-subtotal')
    const total = $('.cart-finish-total')
    const installment = $('.cart-finish-installment')

    let totalPrice = 0

    allCartItems.forEach(value => {
        const price = Number(value.querySelector('.cart-item-info-total-number').textContent)

        totalPrice += price
    });

    subtotal.textContent = `R\$${totalPrice.toFixed(2)}`
    total.textContent = subtotal.textContent
    installment.textContent = `Até 12x de R\$${(totalPrice / 12.0).toFixed(2)} sem juros.`
}




/* ************************************/
/*             Stock Page             */
/***************************************/


function stockPage() {
    if (!$('.stock-main'))
        return

    const enableItemButtons = $all('.enable-item-button')
    const disableItemButtons = $all('.disable-item-button')
    const products = $all('.product-stock-card')

    enableItemButtons.forEach(button => {
        const itemId = button.getAttribute('data-enable-for')
        const itemAssoc = document.getElementById(itemId)

        button.addEventListener('click', () => enable(itemAssoc))
    })

    disableItemButtons.forEach(button => {
        const itemId = button.getAttribute('data-disable-for')
        const itemAssoc = document.getElementById(itemId)

        button.addEventListener('click', () => disable(itemAssoc))
    })

    products.forEach(value => {
        const submitActions = value.querySelector('.product-card-submit-actions')

        const editAction = value.querySelector('.product-stock-edit')
        const cancelAction = value.querySelector('.product-stock-cancel')

        const inputs = value.querySelectorAll('input, select, textarea')

        editAction.onclick = () => {
            for (const input of inputs) {
                input.disabled = false
                enable(submitActions)
            }
            disable(editAction)

            for (const product of products) {
                if (product != value) {
                    disable(product)
                }
            }

            document.location.href = `#name_${value.getAttribute('data-id')}`
        }

        cancelAction.onclick = () => {
            for (const input of inputs) {
                input.disabled = true
                disable(submitActions)
            }
            enable(editAction)

            for (const product of products) {
                product.setAttribute('data-state', 'disabled-show');
            }

            document.location.href = "#";

            window.scrollTo(0, 0);
        }
    })
}

function menuStockPage() {
    const hideTypeList = $('#hide-menu-type-list')
    const typeList = $('.aside-nav')

    if (hideTypeList) {
        hideTypeList.onclick = () => {
            const display = getComputedStyle(typeList).display

            if (display != 'none') {
                typeList.style.display = 'none'
            } else {
                typeList.style.display = 'block'
            }
        }
    }
}

menuStockPage()
stockPage()
menuPage()
cartPage()
