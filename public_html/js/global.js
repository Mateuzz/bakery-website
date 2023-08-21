export function $(selector) {
    return document.querySelector(selector)
}

export function $all(selector) {
    return document.querySelectorAll(selector)
}

export function toggle(element) {
    if (element.getAttribute('data-state') === 'enabled') {
        element.setAttribute('data-state', 'disabled')
    } else {
        element.setAttribute('data-state', 'enabled')
    }
}

export function enable(item) {
    item.setAttribute('data-state', 'enabled')
}

export function disable(item) {
    item.setAttribute('data-state', 'disabled')
}

function setLoadingImagesWheel() {
    const loadingWrapper = $all('.loading-wheel-wrapper')

    for (const lw of loadingWrapper) {
        const img = lw.querySelector('img')
        if (img.complete)
            setTimeout(() => {
                lw.classList.remove('loading-wheel-wrapper')
            }, 400);
        else
            img.addEventListener('load', () => {
                setTimeout(() => {
                    lw.classList.remove('loading-wheel-wrapper')
                }, 400);
            })
    }
}

function initToggleButtons() {

    const toggleItemButtons = $all('.toggle-item-button')

    toggleItemButtons.forEach(button => {
        const id = button.getAttribute('data-toggle-for')
        const item = $('#' + id)
        button.onclick = () => toggle(item)
    })
}


setLoadingImagesWheel()
initToggleButtons()
