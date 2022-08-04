<?= $this->extend(setting('Pages.views')['layout']) ?>

<?= $this->section('title') ?><?= lang('Pages.contact') ?><?= $this->endSection() ?>

<?= $this->section('main') ?>

<div class="standard-form">
    <div class="standard-form-header">
        <h1><?= lang('Pages.contactHeader') ?></h1>
    </div>

    <?= showMessage() ?>

    <div class="standard-form-body">
        <?= form_open(route_to('contact'), ['method' => 'post', 'autocomplete' => 'off']) ?>
            <?= form_group_open('form-group') ?>
                <?= form_label(lang('Pages.subject'), 'subject') ?>
                <?= form_control_open('form-control', 'subject') ?>
                    <?= form_input(['name' => 'subject', 'autofocus' => 'autofocus'], set_value('subject')) ?>
                <?= form_control_close() ?>
                <?= showError('subject', 'my_single') ?>
            <?= form_group_close() ?>
            <?= form_group_open('form-group') ?>
                <?= form_label(lang('Pages.message'), 'message') ?>
                <?= form_control_open('form-control', 'message') ?>
                    <?= form_textarea(['name' => 'message'], set_value('message')) ?>
                <?= form_control_close() ?>
                <?= showError('message', 'my_single') ?>
            <?= form_group_close() ?>
            <?= form_group_open('form-group') ?>
                <?= form_label(lang('Pages.email'), 'email') ?>
                <?= form_control_open('form-control', 'email') ?>
                    <?= form_input(['name' => 'email'], set_value('email', $email)) ?>
                <?= form_control_close() ?>
                <?= showError('email', 'my_single') ?>
            <?= form_group_close() ?>
            <?= form_group_open('form-group') ?>
                <?= $this->include('templates/recaptcha') ?>
                <?= showError('g-recaptcha-response', 'my_single') ?>
            <?= form_group_close() ?>
        <?= form_submit('submit', lang('Pages.sendSubmit')) ?>
        <?= form_close() ?>
    </div>

    <?= $this->include('templates/form_focus') ?>
</div>

<?= $this->endSection() ?>
