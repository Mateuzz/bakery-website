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

function makeBgWideScreenImage(container, img) {
    container.style.backgroundImage = `url(${img.src})`
    container.classList.add('ut-widescreen-bg-img')
    img.remove()
}

function imageRemoveWheelAction(container, img) {
    if (img.complete)
        setTimeout(() => { container.classList.remove('loading-wheel-wrapper') }, 400);
    else
        img.addEventListener('load', () => {
            setTimeout(() => {
                container.classList.remove('loading-wheel-wrapper')
            }, 400);
        })
}

function imageMakeBgWideScreenAction(container, img) {
    if (img.complete) {
        makeBgWideScreenImage(container, img)
    } else {
        img.onload = () => makeBgWideScreenImage(container, img)
    }
}

function imageHandler() {
    const imgs = $all('img')

    for (const img of imgs) {
        const picture = img.parentElement
    
        if (picture.classList.contains("loading-wheel-wrapper")) {
            imageRemoveWheelAction(picture, img)
        }
        
        if (picture.getAttribute('data-onload') == 'make-bg-widescreen') {
            imageMakeBgWideScreenAction(picture, img)
        }
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


imageHandler()
initToggleButtons()
