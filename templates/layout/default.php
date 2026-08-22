<?php
/**
 * Tabler Admin Layout
 * @var \App\View\AppView $this
 *
 * Prefix-specifikus elementek (pl. templates/Admin/element/topheader.php)
 * felülírják a KvAdmin plugin alapértelmezettjeit.
 */
$topheaderElement = $this->elementExists('topheader') ? 'topheader' : 'KvAdmin.topheader';
$headerElement = $this->elementExists('header') ? 'header' : 'KvAdmin.header';
$sidebarElement = $this->elementExists('sidebar') ? 'sidebar' : 'KvAdmin.sidebar';
$footerElement = $this->elementExists('footer') ? 'footer' : 'KvAdmin.footer';
?>
<!doctype html>
<html lang="hu"> <?php // data-bs-theme="dark"> ?>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
    <title>Tabler • <?= $this->fetch('title') ?></title>

    <!-- Tabler CSS --><?= $this->Html->css(['KvAdmin.tabler.min', 'KvAdmin.main']) ?>

	<!-- Vendor CSS --><?= $this->fetch('css') ?>

</head>
<body>

    <div class="page">
        <!-- Sidebar -->
        <?= $this->element($sidebarElement) ?>

        <!-- TopHeader -->
        <?= $this->element($topheaderElement) ?>

        <!-- Header (menü) -->
        <?= $this->element($headerElement) ?>

        <!-- Fő tartalom -->
        <div class="page-wrapper">
            <div class="page-body">
                <div class="container-xl pt-3">
                    <?= $this->Flash->render() ?>

					<!-- Content -->
                    <?= $this->fetch('content') ?>

                </div>
            </div>

            <!-- Footer -->
            <?= $this->element($footerElement) ?>

        </div>
    </div>


    <!-- Tabler JS --><?= $this->Html->script(['KvAdmin.tabler.min']) ?>

	<!-- KvAdmin/Vendor JS -->
	<?= $this->fetch('script') ?>

	<!-- KvAdmin JS -->
	<?= $this->fetch('footer') ?>

</body>
</html>
