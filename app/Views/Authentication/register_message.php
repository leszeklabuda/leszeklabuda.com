<?= $this->extend(setting('Authentication.views')['layout']) ?>

<?= $this->section('title') ?><?= lang('Authentication.register') ?><?= $this->endSection() ?>

<?= $this->section('main') ?>

<div class="auth-form">
    <div class="auth-form-header">
        <h1><?= lang('Authentication.registerHeader') ?></h1>
    </div>
    <div class="auth-form-body">
        <p><?= lang('Authentication.registerSuccess') ?></p>
    </div>

    <div class="link-container">
        <span><?= lang('Pages.goTo') ?></span>
        <?= anchor(route_to('login'), lang('Pages.loginPage'), ['class' => 'link']) ?>
    </div>
</div>

<?= $this->endSection() ?>
