<?= $this->include('templates/top') ?>
    <div class="page-wrapper">
        <header class="header-wrapper">
            <?= $this->include('templates/header') ?>
        </header>
        <section class="main-wrapper">
            <main id="content" class="main-content">
                <?= $this->renderSection('main') ?>
            </main>
        </section>
        <footer class="footer-wrapper">
            <?= $this->include('templates/footer') ?>
        </footer>
    </div>
<?= $this->include('templates/bottom') ?>
