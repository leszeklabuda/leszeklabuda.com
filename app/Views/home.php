<?= $this->extend(setting('Pages.views')['layout']) ?>

<?= $this->section('title') ?><?= lang('Pages.home') ?><?= $this->endSection() ?>

<?= $this->section('main') ?>
    <article>
        <p>HOME PAGE</p>
    </article>
<?= $this->endSection() ?>
