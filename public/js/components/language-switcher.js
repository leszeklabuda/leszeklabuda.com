// Language switcher

(() => {
    const html = document.querySelector('html[lang]');
    if (html) {
        const lang = html.getAttribute('lang');
        const pl = document.querySelector('.pl-switcher');
        const en = document.querySelector('.en-switcher');        
        if (lang === 'pl' && pl) { pl.classList.add('active-menu-item'); }
        if (lang === 'en' && en) { en.classList.add('active-menu-item'); }
    }
})();
