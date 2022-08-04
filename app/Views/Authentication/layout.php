<?= $this->include('templates/top') ?>
    <div class="page-wrapper">
        <section class="main-wrapper">
            <main id="content" class="main-content">
                <div class="container logo-container">
                    <?= $this->include('templates/logo') ?>
                </div>
                <?= $this->renderSection('main') ?>
            </main>
        </section>
    </div>
<?= $this->include('templates/bottom') ?>
