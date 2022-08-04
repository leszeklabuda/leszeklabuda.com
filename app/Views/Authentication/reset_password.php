<?= $this->extend(setting('Authentication.views')['layout']) ?>

<?= $this->section('title') ?><?= lang('Authentication.resetPassword') ?><?= $this->endSection() ?>

<?= $this->section('main') ?>
<div class="auth-form">
    <div class="auth-form-header">
        <h1><?= lang('Authentication.resetPasswordHeader') ?></h1>
    </div>

    <?= showMessage() ?>

    <div class="auth-form-body">
        <?= form_open(route_to('resetPassword', esc($token)), ['method' => 'post', 'autocomplete' => 'off']) ?>
            <?= form_group_open('form-group') ?>
                <?= form_label(lang('Authentication.password'), 'password') ?>
                <?= form_control_open('form-control', 'password') ?>
                <?= form_password(['name' => 'password', 'autocomplete' => 'new-password', 'autofocus' => 'autofocus'], set_value('password')) ?>
                <?= form_control_close() ?>
                <?= showError('password', 'my_single') ?>
                <?= form_button('toggle-password', lang('Authentication.showPassword'), ['class' => 'link toggle-password', 'data-show' => lang('Authentication.showPassword'), 'data-hide' => lang('Authentication.hidePassword')]) ?>
            <?= form_group_close() ?>
            <?= form_group_open('form-group') ?>
                <?= form_label(lang('Authentication.passwordConfirmation'), 'password-confirmation') ?>
                <?= form_control_open('form-control', 'password-confirmation') ?>
                <?= form_password(['name' => 'password-confirmation', 'autocomplete' => 'new-password'], set_value('password-confirmation')) ?>
                <?= form_control_close() ?>
                <?= showError('password-confirmation', 'my_single') ?>
                <?= form_button('toggle-password', lang('Authentication.showPassword'), ['class' => 'link toggle-password', 'data-show' => lang('Authentication.showPassword'), 'data-hide' => lang('Authentication.hidePassword')]) ?>
            <?= form_group_close() ?>
            <?= form_submit('submit', lang('Authentication.resetPasswordSubmit')) ?>
        <?= form_close() ?>
    </div>

    <div class="link-container">
        <span><?= lang('Pages.goTo') ?></span>
        <?= anchor(route_to('login'), lang('Pages.loginPage'), ['class' => 'link']) ?>
    </div>

    <script>
        (() => {
            const element = document.querySelector('.auth-form .form-control.failure input')
                || document.querySelector('.auth-form input[name="password"]');
            if (element) {
                element.focus();
                element.selectionStart = element.selectionEnd = element.value.length;
            }
        })();
    </script>
</div>
<?= $this->endSection() ?>
