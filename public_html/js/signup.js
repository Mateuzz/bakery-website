import {$, $all} from "./global.js"

const AvailableStatus = {
    Available: Symbol("Available"),
    Unavailable: Symbol("Unavailable"),
    Unknown: Symbol("Available"),
}

async function isEmailAvailable(email) {
    return AvailableStatus.Unknown
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
    let invalidPatterns = []
    let customMsg = `${fieldName} must be a valid ${fieldName}`
    const required = field.getAttribute('required')

    if (rule['max'])
        max = rule['max']
    if (rule['min'])
        min = rule['min']
    if (rule['patterns'])
        patterns = rule['patterns']
    if (rule['invalidPatterns'])
        invalidPatterns = rule['invalidPatterns']
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
            console.log(pattern)
            return customMsg
        }
    }

    for (const antiPattern of Object.values(invalidPatterns)) {
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
        const text = await response.text()
        return JSON.parse(text, (key, value) => {
            const ps = []
            if (key == 'patterns' || key == 'invalidPatterns') {
                for (const p of value) {
                    ps.push(new RegExp(p))
                }
            } else {
                return value
            }
            console.log(ps)
            return ps
        })
    } catch (e) {
        return false
    }
}

function stringRulesToRegex(rules) {
    for (const rule of Object.values(rules)) {
        const patterns = rule['patterns']
        const invalidPatterns = rule['invalidPatterns']

        for (const key in patterns) {
            patterns[key] = new RegExp(patterns[key])
        }

        for (const key in invalidPatterns) {
            invalidPatterns[key] = new RegExp(invalidPatterns[key])
        }
    }
}
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

let validationMessageBox = ''

if (document.documentElement.clientWidth > 850) {
    validationMessageBox = 'dialog'
} else {
    validationMessageBox = '.form-validity-message'
}

signupPage()
