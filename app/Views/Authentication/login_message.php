<?= $this->extend(setting('Authentication.views')['layout']) ?>

<?= $this->section('title') ?><?= lang('Authentication.login') ?><?= $this->endSection() ?>

<?= $this->section('main') ?>

<div class="auth-form">
    <div class="auth-form-header">
        <h1><?= lang('Authentication.loginHeader') ?></h1>
    </div>
    <div class="auth-form-body">
        <p><?= lang('Authentication.loginSuccess') ?></p>
    </div>

    <div class="link-container">
        <span><?= lang('Pages.goTo') ?></span>
        <?= anchor(route_to('home'), lang('Pages.homePage'), ['class' => 'link']);?>
    </div>
</div>

<?= $this->endSection() ?>
