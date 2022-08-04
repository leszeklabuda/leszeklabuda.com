// Transition of the navigation and dropdown menus.

const transition = {
    duration: 200
}

// Start of expand transition.
function startExpandTransition(container, menu) {
    const marginTop = parseInt(menu.hasAttribute('data-margin-top') ? menu.getAttribute('data-margin-top') : getStyleProperty(menu, 'marginTop'));
    const marginBottom = parseInt(menu.hasAttribute('data-margin-bottom') ? menu.getAttribute('data-margin-bottom') : getStyleProperty(menu, 'marginBottom'));
    const paddingTop = parseInt(menu.hasAttribute('data-padding-top') ? menu.getAttribute('data-padding-top') : getStyleProperty(menu, 'paddingTop'));
    const paddingBottom = parseInt(menu.hasAttribute('data-padding-bottom') ? menu.getAttribute('data-padding-bottom') : getStyleProperty(menu, 'paddingBottom'));
    menu.style.marginTop = '0px';
    menu.style.marginBottom = '0px';
    menu.style.paddingTop = '0px';
    menu.style.paddingBottom = '0px';
    container.classList.add('show');
    menu.classList.add('active');
    const height = parseInt(menu.hasAttribute('data-height') ? menu.getAttribute('data-height') : menu.offsetHeight + paddingTop + paddingBottom);
    if (!menu.hasAttribute('data-margin-top')) {
        menu.setAttribute('data-margin-top', marginTop);
        menu.setAttribute('data-margin-bottom', marginBottom);
        menu.setAttribute('data-padding-top', paddingTop);
        menu.setAttribute('data-padding-bottom', paddingBottom);
        menu.setAttribute('data-height', height);
    }
    menu.style.height = '0px';
    menu.style.overflowY = 'hidden';
    menu.style.transitionTimingFunction = 'ease-in-out';
    menu.style.transitionDuration = transition.duration + 'ms';
    const dummy = getOffsetHeight(menu);
    menu.style.marginTop = marginTop + 'px';
    menu.style.marginBottom = marginBottom + 'px';
    menu.style.paddingTop = paddingTop + 'px';
    menu.style.paddingBottom = paddingBottom + 'px';
    menu.style.height = height + 'px';
}

// Start of collapse transition.
function startCollapseTransition(container, menu) {
    menu.classList.remove('active');
    const marginTop = parseInt(getStyleProperty(menu, 'marginTop'));
    const marginBottom = parseInt(getStyleProperty(menu, 'marginBottom'));
    const paddingTop = parseInt(getStyleProperty(menu, 'paddingTop'));
    const paddingBottom = parseInt(getStyleProperty(menu, 'paddingBottom'));
    const height = parseInt(menu.hasAttribute('data-height') ? menu.getAttribute('data-height') : menu.offsetHeight);
    if (!menu.hasAttribute('data-margin-top')) {
        menu.setAttribute('data-margin-top', marginTop);
        menu.setAttribute('data-margin-bottom', marginBottom);
        menu.setAttribute('data-padding-top', paddingTop);
        menu.setAttribute('data-padding-bottom', paddingBottom);
        menu.setAttribute('data-height', height);
    }
    menu.style.marginTop = marginTop + 'px';
    menu.style.marginBottom = marginBottom + 'px';
    menu.style.paddingTop = paddingTop + 'px';
    menu.style.paddingBottom = paddingBottom + 'px';
    menu.style.height = menu.offsetHeight + 'px';
    menu.style.overflowY = 'hidden';
    menu.style.transitionTimingFunction = 'ease-in-out';
    menu.style.transitionDuration = transition.duration + 'ms';
    const dummy = getOffsetHeight(menu);
    menu.style.marginTop = '0px';
    menu.style.marginBottom = '0px';
    menu.style.paddingTop = '0px';
    menu.style.paddingBottom = '0px';
    menu.style.height = '0px';
}

// End of dropdown-menu transition.
document.addEventListener('transitionend', e => {
    const menu = e.target;
    const parentElement = menu && menu.parentElement;
    if (parentElement && parentElement.classList.contains('show')) {
        menu.style.marginTop = '';
        menu.style.marginBottom = '';
        menu.style.paddingTop = '';
        menu.style.paddingBottom = '';
        menu.style.height = '';
        menu.style.overflowY = '';
        menu.style.transitionTimingFunction = '';
        menu.style.transitionDuration = '';
        menu.removeAttribute('data-margin-top');
        menu.removeAttribute('data-margin-bottom');
        menu.removeAttribute('data-padding-top');
        menu.removeAttribute('data-padding-bottom');
        menu.removeAttribute('data-height');
        if (!menu.classList.contains('active')) {
            menu.parentElement.classList.remove('show');
        }
    }
});

function getOffsetHeight(element) {
    const initial = 0;
    const height = [...element.children].reduce((height, child) => {
        return height + Number(child.offsetHeight);
    }, initial);

    return height;
}

function getStyleProperty(element, propertyName) {
    const style = element.currentStyle ? element.currentStyle[propertyName] : getComputedStyle(element, null)[propertyName];

    return style;
}
