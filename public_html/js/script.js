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

function toggle(item) {
    if (item.getAttribute('data-state') != 'enabled')
        item.setAttribute('data-state', 'enabled')
    else
        item.setAttribute('data-state', 'disabled')
}

function getUrlAnchor() {
    const anchor = document.location.hash
    return anchor.replace(/\?.*/, "")
}


/* ************************************/
/*             Login
/***************************************/

function nameError(name) {
    if (!name)
        return "Username is required"
    len = name.length
    if (len < 3 || len > 60) {
        return "Name must have between 3 and 60 characters"
    }
    if (/[^\w\s]/.test(name)) {
        return "Name can't have special characters"
    }
    return ""
}

function emailError(email) {
    if (!email)
        return "Email is required"

    if (email.length > 60)
        return "Email must have not more than 60 characters"

    if (!/^[\w\.]+@[\w]+\.[\w]+$/.test(email))
        return "Email must be valid email"
    return ""
}

function birthError(date) {
    if (!date)
        return "Birth Date is required"

    const dateRegex = /^([\d]{1,4})-([\d]{1,2})-([\d]{1,2})$/
    console.log(date)
    const match = date.match(dateRegex)
    if (!match) {
        return "Invalid date format"
    }

    const year = match[1]
    const month = match[2]
    const day = match[3]

    if (isNaN(year) || isNaN(month) || isNaN(day) || month < 1 || month > 12 || day < 1 || day > 31) {
        return "Invalid date format"
    }
    return ""
}

function telError(tel, matches) {
    if (!tel)
        return "Telephone is required"

    const teleRegex = /^([0-9]{2}|\([0-9]{2}\))[\s]*([0-9]{4,5})[\s]*-?[\s]*([0-9]{4})$/;

    if (tel.length > 40)
        return "Telephone must have not more than 40 characters"

    const match = teleRegex.test(tel)
    if (!match)
        return "Telephone must have the format (ddd) xxxx xxxx"

    return ""
}

function passError(pass) {
    if (!pass)
        return "Password is required"

    if (pass.length < 8)
        return "Password must have at least 8 characters"

    if (!/[a-z]/.test(pass) || !/[A-Z]/.test(pass) || !/[0-9]/.test(pass))
        return "Password must have uppercase, lowercase, and numbers"

    return ""
}

function confirmPassError(confirmPass, originalPass) {
    if (confirmPass != originalPass)
        return "Passwords must be equal"
    return ""
}

async function isEmailAvailable(email) {
    email = email.toLowerCase()

    try {
        const response = await fetch(`http://localhost/user/api?get_user=&email=${email}`)
        if (!response.ok)
            return false
        const text = await response.text()
        if (text == "not found")
            return true
        return false
    } catch (e) {
        return true
    }
}

function signupPage() {
    const form = $('.signup-form')
    if (!form)
        return

    const name = form.querySelector("#name")
    const email = form.querySelector("#email")
    const birth = form.querySelector("#birth-date")
    const tel = form.querySelector("#telephone")
    const pass = form.querySelector('#password')
    const passConfirm = form.querySelector('#password-confirm')
    const fields = [name, email, birth, tel, pass, passConfirm]

    let checkForExistingUserInterval = null

    function setValidityMessage(element, msg, type) {
        const msgElement = element.parentElement.querySelector('.form-validity-message')
        if (msg && msg != msgElement.textContent) {
            msgElement.textContent = msg + '.'
        } else {
            msgElement.textContent = ''
        }
    }

    function checkFieldError(element, validateCallback, extraArgs) {
        const error = validateCallback(element.value, extraArgs)
        if (error) {
            setValidityMessage(element, error, 'error')
            element.setCustomValidity(' ')
        } else {
            element.setCustomValidity('')
            setValidityMessage(element, '')
        }
        return error
    }

    function checkEmailOnInputError() {
        email.removeAttribute('data-valid-special')

        if (checkForExistingUserInterval) {
            clearTimeout(checkForExistingUserInterval)
            checkForExistingUserInterval = null
        }

        if (checkFieldError(email, emailError))
            return

        email.setCustomValidity(' ')
        email.setAttribute('data-valid-special', 'validating')

        checkForExistingUserInterval = setTimeout(async () => {
            email.removeAttribute('data-valid-special')
            if (!(await isEmailAvailable(email.value))) {
                setValidityMessage(email, "Email already taken", 'error')
            } else {
                email.setCustomValidity('')
                setValidityMessage(email, "Email is available", 'msg')
            }
        }, 750);
    }

    // for email we don' repeat async request again on submit
    function checkEmailOnSubmitError() {
        return email.validity.customError || checkFieldError(email, emailError)
    }

    name.oninput = () => checkFieldError(name, nameError)
    tel.oninput = () => checkFieldError(tel, telError)
    birth.oninput = () => checkFieldError(birth, birthError)
    pass.oninput = () => checkFieldError(password, passError)
    passConfirm.oninput = () => checkFieldError(passConfirm, confirmPassError, pass.value)
    email.oninput = checkEmailOnInputError

    for (const f of fields) 
        f.submitCheckError = f.oninput

    email.submitCheckError = checkEmailOnSubmitError

    form.onsubmit = e => {
        let firstError = null

        for (const field of fields) {
            if (field.submitCheckError() && !firstError)
                firstError = field
        }

        if (firstError) {
            firstError.focus()
            e.preventDefault()
        }
    }
}


/* ************************************/
/*             Menu Page              */
/***************************************/

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

        function showProductNewImage() {
            const file = stockChangeImage.files[0]
            if (imagesTypes.includes(file.type)) {
                const url = URL.createObjectURL(file)
                productImg.src = url
            } else {
                alert("File uploaded is not a image")
            }
        }

        const stockChangeImage = value.querySelector('.products-stock-change-image input')

        stockChangeImage.onchange = showProductNewImage
    })
}

function sideWide() {
    const loadingWrapper = $all('.loading-wheel-wrapper')

    for (const lw of loadingWrapper) {
        const img = lw.querySelector('img')
        const wheel = lw.querySelector('.loading-wheel')
        if (img.complete)
            lw.classList.remove('loading-wheel-wrapper')
        else
            img.addEventListener('load', () => {
                lw.classList.remove('loading-wheel-wrapper')
            })
    }

    const toggleItemButtons = $all('.toggle-item-button')

    toggleItemButtons.forEach(button => {
        const id = button.getAttribute('data-toggle-for')
        const item = $(`#${id}`)
        console.log(id, item)
        button.onclick = () => toggle(item)
    })
}


stockPage()
menuPage()
cartPage()
sideWide()
signupPage()
