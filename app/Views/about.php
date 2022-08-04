<?= $this->extend(setting('Pages.views')['layout']) ?>

<?= $this->section('title') ?><?= lang('Pages.about') ?><?= $this->endSection() ?>

<?= $this->section('main') ?>
    <article>
        <p>ABOUT PAGE</p>
    </article>
<?= $this->endSection() ?>
