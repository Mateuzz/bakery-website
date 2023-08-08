function $(selector) {
    return document.querySelector(selector)
}

const hideTypeList = $('#hide-menu-type-list')
const typeList = $('.menu-type-list')

hideTypeList.onclick = () => {
    const display = getComputedStyle(typeList).display

    if (display != 'none') {
        typeList.style.display = 'none'
    } else {
        typeList.style.display = 'block'
    }
}
