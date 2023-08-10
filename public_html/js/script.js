function $(selector) {
    return document.querySelector(selector)
}

function $all(selector) {
    return document.querySelectorAll(selector)
}


/* ************************************/
/*             Menu Page              */
/***************************************/

const hideTypeList = $('#hide-menu-type-list')

if (hideTypeList) {
    const typeList = $('.menu-type-list')

    hideTypeList.onclick = () => {
        const display = getComputedStyle(typeList).display

        if (display != 'none') {
            typeList.style.display = 'none'
        } else {
            typeList.style.display = 'block'
        }
    }
}

/* ************************************/
/*             Cart Page              */
/***************************************/

const cartItemsSection = $('.cart-items')

if (cartItemsSection) {
    const allCartItems = $all('.cart-item')
    const subtotal = $('.cart-finish-subtotal')
    const total = $('.cart-finish-total')
    const installment = $('.cart-finish-installment')

    let totalPrice = 0

    allCartItems.forEach(value => {
        const price = Number(value.querySelector('.cart-item-info-total-number').textContent)
        console.log(price)

        totalPrice += price
    });

    subtotal.textContent = `R\$${totalPrice.toFixed(2)}`
    total.textContent = subtotal.textContent
    installment.textContent = `Até 12x de R\$${(totalPrice / 12.0).toFixed(2)} sem juros.`
}


/* ************************************/
/*             Stock Page             */
/***************************************/

function addConfirmEditButton(product) {
    

    buttons.append(confirmButton)
}

const products = $all('.product-stock-card')

products.forEach(value => {
    const submitActions = value.querySelector('.product-card-submit-actions')

    const editAction = value.querySelector('.product-stock-edit')
    const cancelAction = value.querySelector('.product-stock-cancel')

    const inputs = value.querySelectorAll('input, select, textarea')

    editAction.onclick = () => {
        for (const input of inputs)  {
            input.disabled = false
            submitActions.setAttribute('data-state', 'enabled')
        }
        editAction.setAttribute('data-state', 'disabled')
    }

    cancelAction.onclick = () => {
        for (const input of inputs) {
            input.disabled = true
            submitActions.setAttribute('data-state', 'disabled')
        }
        editAction.setAttribute('data-state', 'enabled')
    }
})
