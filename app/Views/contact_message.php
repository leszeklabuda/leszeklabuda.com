<?= $this->extend(setting('Pages.views')['layout']) ?>

<?= $this->section('title') ?><?= lang('Pages.contact') ?><?= $this->endSection() ?>

<?= $this->section('main') ?>

<div class="standard-form">
    <div class="standard-form-header">
        <h1><?= lang('Pages.contactHeader') ?></h1>
    </div>
    <div class="standard-form-body">
        <p><?= lang('Pages.contactSuccess') ?></p>
    </div>

    <div class="link-container">
        <span><?= lang('Pages.goTo') ?></span>
        <?= anchor(route_to('home'), lang('Pages.homePage'), ['class' => 'link']) ?>
    </div>
</div>

<?= $this->endSection() ?>
