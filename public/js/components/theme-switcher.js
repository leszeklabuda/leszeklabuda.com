// Theme switcher

(() => {
    const lowerLimit = 0;
    const upperLimit = 255;
    const duration = 200;
    const steps = 64;
    const period = 0.08 * duration * steps / (upperLimit + 1);

    const body = document.querySelector('body');
    const themeSwitcher = document.querySelector('.theme-switcher');
    const lightThemeSwitcher = document.querySelector('.light-theme-switcher');
    const darkThemeSwitcher = document.querySelector('.dark-theme-switcher');
    const themeColor = document.querySelector('meta[name="theme-color"]');

    if (body && themeSwitcher) {
        const theme = getCookie('theme');
        if (theme) {
            updateComponents(theme);
        }
        else {
            setCookie('theme', 'light', Infinity);
            updateComponents('light');
        }

        if (lightThemeSwitcher) {
            lightThemeSwitcher.addEventListener('click', () => {
                setCookie('theme', 'light', Infinity);
                if (body && !body.classList.contains('light')) {
                    body.classList.remove('dark');
                    body.classList.add('light');
                }
                if (themeColor && themeColor.content !== '#ffffff') {
                    lightTransition();
                }
                updateComponents('light');
                updateRecaptcha('light');
            });
        }

        if (darkThemeSwitcher) {
            darkThemeSwitcher.addEventListener('click', () => {
                setCookie('theme', 'dark', Infinity);
                if (body && !body.classList.contains('dark')) {
                    body.classList.remove('light');
                    body.classList.add('dark');
                }
                if (themeColor && themeColor.content !== '#000000') {
                    darkTransition();
                }
                updateComponents('dark');
                updateRecaptcha('dark');
            });
        }
    }

    function updateComponents(theme) {
        const icon = themeSwitcher ? themeSwitcher.querySelector('span.icon') : null;
        if (theme === 'dark') {
            if (icon) {
                icon.classList.remove('icon-light_mode');
                icon.classList.add('icon-dark_mode');
            }
            if (lightThemeSwitcher && darkThemeSwitcher) {
                lightThemeSwitcher.classList.remove('active-menu-item');
                darkThemeSwitcher.classList.add('active-menu-item');
            }
        }
        else {
            if (icon) {
                icon.classList.remove('icon-dark_mode');
                icon.classList.add('icon-light_mode');
            }
            if (lightThemeSwitcher && darkThemeSwitcher) {
                darkThemeSwitcher.classList.remove('active-menu-item');
                lightThemeSwitcher.classList.add('active-menu-item');
            }
        }
    }

    function updateRecaptcha(theme) {
        if (window.resetRecaptcha) {
            window.resetRecaptcha(theme);
        }
    }

    function lightTransition(lightness = lowerLimit) {
        setThemeColor(lightness, 'light');
        if (lightness < upperLimit) {
            lightness += steps;
            if (lightness > upperLimit) { lightness = upperLimit; }
            setTimeout(lightTransition, period, lightness);
        }
    }

    function darkTransition(lightness = upperLimit) {
        setThemeColor(lightness, 'dark');
        if (lightness > lowerLimit) {
            lightness -= steps;
            if (lightness < lowerLimit) { lightness = lowerLimit; }
            setTimeout(darkTransition, period, lightness);
        }
    }

    function setThemeColor(lightness, theme) {
        lightness = (lightness < 16 ? '0' : '') + Number(lightness).toString(16);
        const color = '#' + lightness + lightness + lightness;
        if (themeColor) {
            themeColor.setAttribute("content", color);
        }
    }

    function getCookie(name) {
        const cookies = decodeURIComponent(document.cookie);
        const pairs = cookies.split(";").map(cookie => cookie.trim().split("="));
        const pair = pairs.find(pair => pair[0] === name);

        if(pair) {
            return pair[1];
        }

        return null;
    }

    function setCookie(name, value, expires = null, path = '/', domain = '') {
        if (expires === 0) {
            expires = '01 Jan 1970 00:00:01 GMT';
        }
        else if (expires === Infinity) {
            expires = '19 Jan 2038 03:14:07 GMT';
        }
        else if (Number.isInteger(expires) && expires > 0) {
            const date = new Date();
            date.setTime(date.getTime() + (expires * 1000));
            expires = date.toGMTString();
        }

        const cookie = name + '=' + value.trim()
            + (expires !== null ? '; expires=' + expires : '')
            + '; path=' + path;
            + (domain ? '; domain=' + domain : '');

        document.cookie = cookie;
    }
})();
