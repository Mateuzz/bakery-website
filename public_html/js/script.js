function $(selector) {
    return document.querySelector(selector)
}

const hideTypeList = $('#hide-menu-type-list')
const typeList = $('.menu-type-list')

const frames = [
    { translate: 0 },
    { translate: '-12em' },
]

const framesReverse = [
    { translate: '-12em' },
    { translate: 0 },
]

const timing = {
    duration: 100,
    fill: 'forwards',
    timing: 'linear'
}

hideTypeList.onclick = () => {
    const display = getComputedStyle(typeList).display

    if (display != 'none') {
        typeList.animate(frames, timing)
        setTimeout(() => {
            typeList.style.display = 'none'
        }, 100);
    } else {
        typeList.style.display = 'block'
        typeList.animate(framesReverse, timing)
    }
}
