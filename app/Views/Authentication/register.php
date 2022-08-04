<?= $this->extend(setting('Authentication.views')['layout']) ?>

<?= $this->section('title') ?><?= lang('Authentication.register') ?><?= $this->endSection() ?>

<?= $this->section('main') ?>

<div class="auth-form">
    <div class="auth-form-header">
        <h1><?= lang('Authentication.registerHeader') ?></h1>
    </div>

    <?= showMessage() ?>

    <div class="auth-form-body">
        <?= form_open(route_to('register'), ['method' => 'post', 'autocomplete' => 'off']) ?>
            <?= form_group_open('form-group') ?>
                <?= form_label(lang('Authentication.username'), 'username') ?>
                <?= form_control_open('form-control', 'username') ?>
                    <?= form_input(['name' => 'username', 'autocomplete' => 'username', 'autofocus' => 'autofocus'], set_value('username')) ?>
                <?= form_control_close() ?>
                <?= showError('username', 'my_single') ?>
            <?= form_group_close() ?>
            <?= form_group_open('form-group') ?>
                <?= form_label(lang('Authentication.password'), 'password') ?>
                <?= form_control_open('form-control', 'password') ?>
                    <?= form_password(['name' => 'password', 'autocomplete' => 'new-password'], set_value('password')) ?>
                <?= form_control_close() ?>
                <?= showError('password', 'my_single') ?>
                <?= form_button('toggle-password', lang('Authentication.showPassword'), ['class' => 'link toggle-password', 'data-show' => lang('Authentication.showPassword'), 'data-hide' => lang('Authentication.hidePassword')]) ?>
            <?= form_group_close() ?>
            <?= form_group_open('form-group') ?>
                <?= form_label(lang('Authentication.email'), 'email') ?>
                <?= form_control_open('form-control', 'email') ?>
                    <?= form_input(['name' => 'email', 'autocomplete' => 'email'], set_value('email')) ?>
                <?= form_control_close() ?>
                <?= showError('email', 'my_single') ?>
            <?= form_group_close() ?>
            <?= form_group_open('form-group') ?>
                <?= $this->include('templates/recaptcha') ?>
                <?= showError('g-recaptcha-response', 'my_single') ?>
            <?= form_group_close() ?>
        <?= form_submit('submit', lang('Authentication.registerSubmit')) ?>
        <?= form_close() ?>
    </div>

    <div class="link-container">
        <span><?= lang('Authentication.haveAccount') ?></span>
        <?= anchor(route_to('login'), lang('Authentication.login'), ['class' => 'link']);?>
    </div>

    <?= $this->include('templates/form_focus') ?>
</div>

<?= $this->endSection() ?>
