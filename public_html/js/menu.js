import {$, $all, enable, disable} from "./global.js"

function getUrlAnchor() {
    const anchor = document.location.hash
    return anchor.replace(/\?.*/, "")
}

function menuPage() {
    const menuSelectCategoryButtons = $all('.menu-select-category')

    const products = $all('.product-menu-card')
    const anchor = getUrlAnchor()

    function filterProducts(button) {
        const id = button.getAttribute('data-category-id')

        for (const product of products) {
            const productId = product.getAttribute('data-category-id')
            if (productId == id) {
                enable(product)
            } else {
                disable(product)
            }
        }
    }

    for (const button of menuSelectCategoryButtons) {
        // if is empty will go in the first button
        if (button.href.includes(anchor)) {
            filterProducts(button)
            break
        }
    }

    menuSelectCategoryButtons.forEach(button => {
        button.onclick = () => {
            filterProducts(button)
        }
    })
}

menuPage()
