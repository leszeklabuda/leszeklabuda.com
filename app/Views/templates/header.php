<nav class="container top-navigation">
    <div class="top-navigation-wrapper">
        <?= view('templates/logo', $this->data) ?>
        <button type="button" class="button main-menu-toggle" title="Open main menu">
            <span class="icon material-icons icon-menu"></span>
        </button>
    </div>
    <div class="top-navigation-main">
        <nav class="main-nav">
            <ul role="menu" class="main-menu">
                <li>
                    <div class="dropdown">
                        <a class="button dropdown-button">
                            <?= lang('Pages.articles') ?>
                            <span class="icon material-icons icon-expand_more expand"></span>
                        </a>
                        <ul role="menu" class="dropdown-menu">
                            <li>
                                <a class="button" href="">
                                    Apache
                                </a>
                            </li>
                            <li>
                                <a class="button" href="">
                                    PHP
                                </a>
                            </li>
                            <li>
                                <a class="button" href="">
                                    HTML5/CSS3/JS
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li>
                    <?= anchor(lang_url('Routes.about'), lang('Pages.about'), ['class' => 'button']);?>
                </li>
                <li>
                    <?= anchor(lang_url('Routes.contact'), lang('Pages.contact'), ['class' => 'button']);?>
                </li>
            </ul>
        </nav>

        <div class="theme-switcher-menu dropdown">
            <a class="button theme-switcher dropdown-button">
                <span class="icon material-icons icon-light_mode"></span>
                <?= rn(lang('Themes.theme')) ?>
                <span class="icon material-icons icon-expand_more expand"></span>
            </a>
            <ul role="menu" class="themes-menu dropdown-menu">
                <li>
                    <a class="button light-theme-switcher">
                        <span class="icon material-icons icon-light_mode"></span>
                        <?= rn(lang('Themes.light')) ?>
                    </a>
                </li>
                <li>
                    <a class="button dark-theme-switcher">
                        <span class="icon material-icons icon-dark_mode"></span>
                        <?= rn(lang('Themes.dark'));?>
                    </a>
                </li>
            </ul>
        </div>
        <div class="language-switcher-menu dropdown">
            <a type="button" class="button language-switcher dropdown-button">
                <span class="icon material-icons icon-language"></span>
                <?= rn(lang('Languages.language')) ?>
                <span class="icon material-icons icon-expand_more expand"></span>
            </a>
            <ul role="menu" class="languages-menu dropdown-menu">
                <li>
                    <a class="button pl-switcher" <?= $locale === 'pl' ? '' : 'href=' . $navi['pl']['url']?>>
                        <img src="/img/poland.png" alt="" class="flag">
                        <?=rn($navi['pl']['title']) ?>
                    </a>
                </li>
                <li>
                    <a class="button en-switcher" <?= $locale === 'en' ? '' : 'href=' . $navi['en']['url']?>>
                        <img src="/img/united-kingdom.png" alt="" class="flag">
                        <?=rn($navi['en']['title']) ?>
                    </a>
                </li>
            </ul>
        </div>
        <div class="dropdown">
            <a class="button dropdown-button">
                <span class="icon material-icons icon-person"></span>
                <?= $username ?>
                <span class="icon material-icons icon-expand_more expand"></span>
            </a>
            <ul role="menu" class="dropdown-menu">
            <?php if(!$loggedIn): ?>
                <li>
                    <a class="button" href="<?= route_to('login') ?>">
                        <span class="icon material-icons icon-login"></span>
                        <?= rn(lang('Authentication.login')) ?>
                    </a>
                </li>
                <li>
                    <a class="button" href="<?= route_to('register') ?>">
                        <span class="icon material-icons icon-app_registration"></span>
                        <?= rn(lang('Authentication.register')) ?>
                    </a>
                </li>
            <?php endif ?>
            <?php if($loggedIn): ?>
                <li>
                    <a class="button" href="<?= route_to('logout') ?>">
                        <span class="icon material-icons icon-logout"></span>
                        <?= rn(lang('Authentication.logout')) ?>
                    </a>
                </li>
            <?php endif ?>
            </ul>
    </div>
</nav>
