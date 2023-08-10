function $(selector) {
    return document.querySelector(selector)
}

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

const cartItemsSection = $('.cart-items')

if (cartItemsSection) {
    const allCartItems = document.querySelectorAll('.cart-item')
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
