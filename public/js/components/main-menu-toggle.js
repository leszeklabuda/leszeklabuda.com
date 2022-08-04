// Main menu toggle button

(() => {
    const navigation = document.querySelector('.top-navigation');

    if (navigation) {
        const navigationButton = document.querySelector('.main-menu-toggle');
        const navigationMenu = navigation.querySelector('.top-navigation-main');

        // Expand or collapse the top navigation after clicking the menu button.
        navigationButton.addEventListener('click', () => {
            if (navigationMenu.classList.contains('active')) {
                collapse(navigation);
            }
            else {
                expand(navigation);
            }
        });

        // Collapse the top navigation when clicking outside of the header container.
        document.addEventListener('click', e => {
            if (!e.target.closest('.header-wrapper')) {
                if (navigationMenu.classList.contains('active')) {
                    collapse(navigation);
                }
            }
        });
    }

    // Expand the top navigation.
    function expand(navigation) {
        const icon = navigation.querySelector('.main-menu-toggle span.icon');
        if (icon) {
            icon.classList.remove('icon-menu');
            icon.classList.add('icon-close');
        }
        const navigationMenu = navigation.querySelector('.top-navigation-main');
        if (navigationMenu) {
            startExpandTransition(navigation, navigationMenu);
        }
    }

    // Collapse the top navigation.
    function collapse(navigation) {
        const icon = navigation.querySelector('.main-menu-toggle span.icon');
        if (icon) {
            icon.classList.remove('icon-close');
            icon.classList.add('icon-menu');
        }
        const navigationMenu = navigation.querySelector('.top-navigation-main');
        if (navigationMenu) {
            startCollapseTransition(navigation, navigationMenu);
        }
    }
})();
