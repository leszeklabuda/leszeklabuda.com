// Dropdown menu

document.addEventListener('click', e => {
    const dropdown = e.target.closest('.dropdown');

    if (dropdown) {
        const dropdownButton = e.target.closest('.dropdown-button');
        const dropdownMenu = dropdown.querySelector('.dropdown-menu');

        // Expand or collapse the drop-down menu after clicking the drop-down button.
        if (dropdownButton) {
            if (dropdownMenu.classList.contains('active')) {
                collapse(dropdown);
            }
            else {
                expand(dropdown);
            }
        }
        else {
            collapse(dropdown);
        }
    }

    // Collapse other drop-down menus that are not the ancestors of the current drop-down menu.
    for (const otherDropdown of document.querySelectorAll('.dropdown.show')) {
        if (otherDropdown !== dropdown) {
            if (!otherDropdown.contains(dropdown)) {
                collapse(otherDropdown);
            }
        }
    }

    // Expand the drop-down menu.
    function expand(dropdown) {
        const icon = dropdown.querySelector('.expand');
        if (icon) {
            icon.classList.remove('icon-expand_more');
            icon.classList.add('icon-expand_less');
        }
        const dropdownMenu = dropdown.querySelector('.dropdown-menu');
        if (dropdownMenu) {
            startExpandTransition(dropdown, dropdownMenu);
        }
    }

    // Collapse the drop-down menu.
    function collapse(dropdown) {
        const icon = dropdown.querySelector('.expand');
        if (icon) {
            icon.classList.remove('icon-expand_less');
            icon.classList.add('icon-expand_more');
        }
        const dropdownMenu = dropdown.querySelector('.dropdown-menu');
        if (dropdownMenu) {
            startCollapseTransition(dropdown, dropdownMenu);
        }
    }
});
