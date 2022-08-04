// g-recaptcha

function onloadCallback() {
    renderRecaptcha();

    function renderRecaptcha(theme = null) {
        if(!theme) {
            const body = document.querySelector('body[class]');
            theme = body ? body.getAttribute('class') : 'light';
            // const colorScheme = document.querySelector('meta[name="color-scheme"]');
            // theme = colorScheme ? colorScheme.getAttribute('content') : 'light';
        }
        const recaptchaContainer = document.querySelector('.g-recaptcha-container');
        if(recaptchaContainer) {
            const siteKey = recaptchaContainer.getAttribute('data-sitekey');
            window.widgetId = grecaptcha.render(document.querySelector('.g-recaptcha'), {
                'sitekey': siteKey,
                'theme': theme,
                'data-size': 'normal'
            });
        }
    }

    window.resetRecaptcha = function (theme) {
        const recaptchaContainer = document.querySelector('.g-recaptcha-container');
        if (recaptchaContainer) {
            const recaptcha = recaptchaContainer.querySelector('.g-recaptcha');
            const newRecaptcha = recaptcha.cloneNode(false);
            recaptcha.remove();
            recaptchaContainer.appendChild(newRecaptcha);
            renderRecaptcha(theme);
        }
    };
}
