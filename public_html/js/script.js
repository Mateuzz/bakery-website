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
/*             Signup
/***************************************/

const AvailableStatus = {
    Available: Symbol("Available"),
    Unavailable: Symbol("Unavailable"),
    Unknown: Symbol("Available"),
}

async function isEmailAvailable(email) {
    // return AvailableStatus.Unknown
    email = email.toLowerCase()

    try {
        const response = await fetch(`http://localhost/user/api?get_user=&email=${email}`)
        if (!response.ok)
            throw new Error("Server Request failed")

        const text = await response.text()
        if (text == "")
            return AvailableStatus.Available
        else
            return AvailableStatus.Unavailable
    } catch (e) {
        return AvailableStatus.Unknown
    }
}

function basicValidation(field, {fieldName, rule}) {
    const value = field.value
    const len = value.length;

    let max = Infinity
    let min = 0
    let patterns = []
    let antiPatterns = []
    let customMsg = `${fieldName} must be a valid ${fieldName}`
    const required = field.getAttribute('required')

    if (rule['max'])
        max = rule['max']
    if (rule['min'])
        min = rule['min']
    if (rule['patterns'])
        patterns = rule['patterns']
    if (rule['antiPatterns'])
        antiPatterns = rule['antiPatterns']
    if (rule['msg'])
        customMsg = rule['msg']

    if (len == 0 && required === '')
        return `${fieldName} is required`

    if (len < min)
        return `${fieldName} must have at least ${min} characters`;
    if (len > max)
        return `${fieldName} must have at most ${max} characters`;

    for (const pattern of Object.values(patterns)) {
        if (!pattern.test(value)) {
            return customMsg
        }
    }

    for (const antiPattern of Object.values(antiPatterns)) {
        if (antiPattern.test(value)) {
            return customMsg
        }
    }

    return ""
}

async function fetchValidationRules() {
    try {
        const response = await fetch("http://localhost/user/api?get-validation-rules=")
        if (!response.ok) {
            return false
        }
        const json = await response.json()
        return json
    } catch (e) {
        return false
    }
}

function stringRulesToRegex(rules) {
    for (const rule of Object.values(rules)) {
        const patterns = rule['patterns']
        const antiPatterns = rule['antiPatterns']

        for (const key in patterns) {
            patterns[key] = new RegExp(patterns[key])
        }

        for (const key in antiPatterns) {
            antiPatterns[key] = new RegExp(antiPatterns[key])
        }
    }
}

let validationMessageBox = ''

// function updateMessageValidationMode() {
//     let newBox = ''

//     if (document.documentElement.clientWidth > 850) {
//         newBox = 'dialog' 
//     } else {
//         newBox = '.form-validity-message'
//     }

//     if (newBox == validationMessageBox)
//         return

//     const groups = $all('.form-group')

//     for (const group of groups) {
//         const oldMessage = group.querySelector(validationMessageBox)
//         const newMessage = group.querySelector(newBox)

//         if (validationMessageBox == 'dialog')
//             oldMessage.open = false
//         else
//             newMessage.open = true

//         newMessage.textContent = oldMessage.textContent
//         oldMessage.textContent = ''
//     }

//     validationMessageBox = newBox
// }

if (document.documentElement.clientWidth > 850) {
    validationMessageBox = 'dialog'
} else {
    validationMessageBox = '.form-validity-message'
}

// window.visualViewport.onresize = updateMessageValidationMode

function setValidityMessage(element, msg) {
    const msgElement = element.parentElement.querySelector(validationMessageBox)

    if (!msg) {
        msgElement.textContent = ''
        msgElement.open = false
    }
    else if (msg != msgElement.textContent) {
        msgElement.textContent = msg + '.'
        msgElement.open = true
    }
}

function setInvalid(element, msg) {
    setValidityMessage(element, msg)
    element.setCustomValidity(' ')
}

function setValid(element, msg) {
    setValidityMessage(element, msg)
    element.setCustomValidity('')
}

function onInputCheckError(element, validateCallback, extraArgs) {
    const error = validateCallback(element, extraArgs)
    if (error) {
        setInvalid(element, error)
    } else {
        setValid(element)
    }
    return error
}

function signupPage() {
    const form = $('.signup-form')
    if (!form)
        return

    const fields = {
        name: null,
        email: null,
        'birth-date': null,
        telephone: null,
        password: null,
        'password-confirm': null
    }

    for (const id in fields)
        fields[id] = form.querySelector('#' + id)

    const rules = fetchValidationRules()

    rules.then(rules => {
        stringRulesToRegex(rules)

        for (const id in fields) {
            // these have exceptional rules
            if (id == 'email' || id == 'password-confirm')
                continue

            const rule = rules[id]

            if (rule) {
                const fieldName = id[0].toUpperCase(0) + id.substring(1)
                fields[id].oninput = () => onInputCheckError(fields[id], basicValidation, {
                    fieldName: fieldName,
                    rule: rule
                })

                fields[id].onSubmitCheckError = fields[id].oninput
            }
        }

        const emailRule = rules['email']
        const email = fields['email']

        let validatingTimeoutId = null

        if (emailRule && email) {
            email.oninput = () => {
                email.removeAttribute('data-valid-special')

                if (validatingTimeoutId) {
                    clearTimeout(validatingTimeoutId)
                    validatingTimeoutId = null
                }

                if (onInputCheckError(email, basicValidation, {
                    fieldName: 'Email',
                    rule: emailRule
                }))
                    return

                email.setCustomValidity(' ')
                email.setAttribute('data-valid-special', 'validating')

                setValidityMessage(email, "Waiting for server confirm email availability")

                validatingTimeoutId = setTimeout(async () => {
                    const status = await isEmailAvailable(email.value)

                    switch (status) {
                    case AvailableStatus.Unavailable:
                        email.removeAttribute('data-valid-special')
                        setInvalid(email, "Email already taken")
                        break;

                    case AvailableStatus.Available:
                        email.removeAttribute('data-valid-special')
                        setValid(email, "Email is available")
                        break;

                    case AvailableStatus.Unknown:
                        email.setAttribute('data-valid-special', 'unknown')
                        setValid(email, "Server not responding: Email may not be available")
                        break;
                    }
                }, 1500);
            }

            email.onSubmitCheckError = () => {
                return email.validity.customError ||
                    onInputCheckError(email, basicValidation, {
                        fieldName: 'Email',
                        rule: emailRule
                    })
            }
        }

        const passConfirm = fields['password-confirm']
        passConfirm.oninput = () => {
            return onInputCheckError(passConfirm, () => {
                if (passConfirm.value != fields['password'].value)
                    return "Passwords do not match"
                return ""
            })
        }
        passConfirm.onSubmitCheckError = passConfirm.oninput

        form.onsubmit = e => {
            let firstError = null

            for (const field of Object.values(fields)) {
                if (field.onSubmitCheckError() && !firstError)
                    firstError = field
            }

            if (firstError) {
                firstError.focus()
                e.preventDefault()
            }
        }
    })
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
        if (img.complete)
            setTimeout(() => {
                lw.classList.remove('loading-wheel-wrapper')
            }, 1000);
        else
            img.addEventListener('load', () => {
                setTimeout(() => {
                    lw.classList.remove('loading-wheel-wrapper')
                }, 1000);
            })
    }

    const toggleItemButtons = $all('.toggle-item-button')

    toggleItemButtons.forEach(button => {
        const id = button.getAttribute('data-toggle-for')
        const item = $('#' + id)
        button.onclick = () => toggle(item)
    })
}


stockPage()
menuPage()
cartPage()
sideWide()
signupPage()
