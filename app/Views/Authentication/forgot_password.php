<?= $this->extend(setting('Authentication.views')['layout']) ?>

<?= $this->section('title') ?><?= lang('Authentication.forgotPassword') ?><?= $this->endSection() ?>

<?= $this->section('main') ?>
<div class="auth-form">
    <div class="auth-form-header">
        <h1><?= lang('Authentication.forgotPasswordHeader') ?></h1>
    </div>

    <?= showMessage() ?>

    <div class="auth-form-body">
        <?= form_open(route_to('forgotPassword'), ['method' => 'post', 'autocomplete' => 'off']) ?>
            <?= form_group_open('form-group') ?>
                <?= form_label(lang('Authentication.email'), 'email') ?>
                <?= form_control_open('form-control', 'email') ?>
                    <?= form_input(['name' => 'email', 'autocomplete' => 'email', 'autofocus' => 'autofocus'], set_value('email')) ?>
                <?= form_control_close() ?>
                <?= showError('email', 'my_single') ?>
            <?= form_group_close() ?>
            <?= form_group_open('form-group') ?>
                <?= $this->include('templates/recaptcha') ?>
                <?= showError('g-recaptcha-response', 'my_single') ?>
            <?= form_group_close() ?>
        <?= form_submit('submit', lang('Authentication.forgotPasswordSubmit')) ?>
        <?= form_close() ?>
    </div>

    <div class="link-container">
        <span><?= lang('Pages.goTo') ?></span>
        <?= anchor(route_to('login'), lang('Pages.loginPage'), ['class' => 'link']) ?>
    </div>

    <?= $this->include('templates/form_focus') ?>
</div>

<?= $this->endSection() ?>
