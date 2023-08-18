import {$, $all, enable, disable} from "./global.js"

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

        const productImg = value.querySelector('img')
        const originalProductImgSrc = productImg.src

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

            productImg.src = originalProductImgSrc
            if (newImageUrl) {
                URL.revokeObjectURL(newImageUrl)
                newImageUrl = null
            }

            document.location.href = "#";

            window.scrollTo(0, 0);
        }

        const imagesTypes = [
            "image/apng",
            "image/bmp",
            "image/gif",
            "image/jpeg",
            "image/pjpeg",
            "image/png",
            "image/svg+xml",
            "image/tiff",
            "image/webp",
            "image/x-icon",
        ]

        let newImageUrl = null

        function showProductNewImage() {
            const file = stockChangeImage.files[0]
            if (imagesTypes.includes(file.type)) {
                newImageUrl = URL.createObjectURL(file)
                productImg.src = url
            } else {
                alert("File uploaded is not a image")
            }
        }

        const stockChangeImage = value.querySelector('.products-stock-change-image input')

        stockChangeImage.onchange = showProductNewImage
    })
}

stockPage()
