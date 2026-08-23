<?php
use Cake\Core\Plugin;

/*
$appLogoPath = WWW_ROOT . 'img' . DS . 'logo_5.svg';
$pluginLogoPath = Plugin::path('KvAdmin') . 'webroot' . DS . 'img' . DS . 'logo.svg';

if (file_exists($appLogoPath)) {
    // A fő alkalmazás webrootjából tölti: /img/logo_5.svg
    $logoSrc = 'logo_5.svg';
} elseif (file_exists($pluginLogoPath)) {
    // A KvAdmin pluginból tölti: /kv_admin/img/logo.svg
    $logoSrc = 'KvAdmin.logo.svg';
} else {
    $logoSrc = null;
}
*/
$prefixKey = strtolower((string)$this->getRequest()->getParam('prefix', ''));
$targetUrl = $prefixKey !== '' ? '/' . $prefixKey : '/';

$roleLabels = [
    'admin' => __('Admin'),
    'new' => __('New user'),
    'member' => __('Member'),
    'clubpresident' => __('Clubpresident'),
    'president' => __('President'),
];
$roleLabel = $roleLabels[$prefixKey] ?? '';
?>
<header class="navbar navbar-expand-md d-print-none">
    <div class="container-xl">
        <!-- BEGIN NAVBAR TOGGLER -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu" aria-controls="navbar-menu" aria-expanded="false" aria-label="<?= __('Toggle navigation') ?>">
            <span class="navbar-toggler-icon"></span>
        </button>
        <!-- END NAVBAR TOGGLER -->

        <!-- BEGIN NAVBAR LOGO + ROLE -->
        <div class="navbar-brand navbar-brand-autodark d-none-navbar-horizontal pe-0 pe-md-3">
            <?= $this->Html->link(
                $this->Icon->outline('logo', ['class' => 'logo'])
                . ($roleLabel !== '' ? '<span class="navbar-role-label">' . h($roleLabel) . '</span>' : ''),
                $targetUrl,
                [
                    'escape' => false,
                    'class' => 'navbar-brand-role d-flex align-items-center text-reset text-decoration-none',
                    'aria-label' => $roleLabel !== '' ? $roleLabel : __('Home'),
                ]
            ) ?>
        </div>
        <!-- END NAVBAR LOGO + ROLE -->

        <div class="navbar-nav flex-row order-md-last">

<?php /*
            <div class="nav-item d-none d-md-flex me-3">
                <div class="btn-list">
                    <?= $this->Html->link(
                        $this->Icon->outline('brand-github', ['class' => 'icon icon-2']) . ' ' . __('Source code'),
                        'https://github.com/tabler/tabler',
                        [
                            'escape' => false,
                            'class' => 'btn btn-5',
                            'target' => '_blank',
                            'rel' => 'noreferrer'
                        ]
                    ) ?>

                    <?= $this->Html->link(
                        $this->Icon->outline('heart', ['class' => 'icon text-pink icon-2']) . ' ' . __('Sponsor'),
                        'https://github.com/sponsors/codecalm',
                        [
                            'escape' => false,
                            'class' => 'btn btn-6',
                            'target' => '_blank',
                            'rel' => 'noreferrer'
                        ]
                    ) ?>
                </div>
            </div>
*/ ?>

            <div class="d-none d-md-flex">
<?php /*
                <div class="nav-item">
                    <?= $this->Html->link(
                        $this->Icon->outline('moon', ['class' => 'icon icon-1']),
                        ['?' => ['theme' => 'dark']],
                        [
                            'escape' => false,
                            'class' => 'nav-link px-0 hide-theme-dark',
                            'data-bs-toggle' => 'tooltip',
                            'data-bs-placement' => 'bottom',
                            'aria-label' => __('Enable dark mode'),
                            'data-bs-original-title' => __('Enable dark mode')
                        ]
                    ) ?>

                    <?= $this->Html->link(
                        $this->Icon->outline('sun', ['class' => 'icon icon-1']),
                        ['?' => ['theme' => 'light']],
                        [
                            'escape' => false,
                            'class' => 'nav-link px-0 hide-theme-light',
                            'data-bs-toggle' => 'tooltip',
                            'data-bs-placement' => 'bottom',
                            'aria-label' => __('Enable light mode'),
                            'data-bs-original-title' => __('Enable light mode')
                        ]
                    ) ?>
                </div>
*/ ?>

<?php /*
                <!-- Értesítések (Notifications) -->
                <div class="nav-item dropdown d-none d-md-flex">
                    <a href="#" class="nav-link px-0" data-bs-toggle="dropdown" tabindex="-1" aria-label="<?= __('Show notifications') ?>" data-bs-auto-close="outside" aria-expanded="false">
                        <?= $this->Icon->outline('bell', ['class' => 'icon icon-1']) ?>
                        <span class="badge bg-red"></span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-end dropdown-menu-card">
                        <div class="card">
                            <div class="card-header d-flex">
                                <h3 class="card-title"><?= __('Notifications') ?></h3>
                                <div class="btn-close ms-auto" data-bs-dismiss="dropdown"></div>
                            </div>
                            <div class="list-group list-group-flush list-group-hoverable">
                                <div class="list-group-item">
                                    <div class="row align-items-center">
                                        <div class="col-auto"><span class="status-dot status-dot-animated bg-red d-block"></span></div>
                                        <div class="col text-truncate">
                                            <a href="#" class="text-body d-block"><?= __('Example 1') ?></a>
                                            <div class="d-block text-secondary text-truncate mt-n1">Change deprecated html tags to text decoration classes (#29604)</div>
                                        </div>
                                        <div class="col-auto">
                                            <a href="#" class="list-group-item-actions">
                                                <?= $this->Icon->outline('star', ['class' => 'icon text-muted icon-2']) ?>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="list-group-item">
                                    <div class="row align-items-center">
                                        <div class="col-auto"><span class="status-dot d-block"></span></div>
                                        <div class="col text-truncate">
                                            <a href="#" class="text-body d-block"><?= __('Example 2') ?></a>
                                            <div class="d-block text-secondary text-truncate mt-n1">justify-content:between ⇒ justify-content:space-between (#29734)</div>
                                        </div>
                                        <div class="col-auto">
                                            <a href="#" class="list-group-item-actions show">
                                                <?= $this->Icon->outline('star', ['class' => 'icon text-yellow icon-2']) ?>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="list-group-item">
                                    <div class="row align-items-center">
                                        <div class="col-auto"><span class="status-dot d-block"></span></div>
                                        <div class="col text-truncate">
                                            <a href="#" class="text-body d-block"><?= __('Example 3') ?></a>
                                            <div class="d-block text-secondary text-truncate mt-n1">Update change-version.js (#29736)</div>
                                        </div>
                                        <div class="col-auto">
                                            <a href="#" class="list-group-item-actions">
                                                <?= $this->Icon->outline('star', ['class' => 'icon text-muted icon-2']) ?>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="list-group-item">
                                    <div class="row align-items-center">
                                        <div class="col-auto"><span class="status-dot status-dot-animated bg-green d-block"></span></div>
                                        <div class="col text-truncate">
                                            <a href="#" class="text-body d-block"><?= __('Example 4') ?></a>
                                            <div class="d-block text-secondary text-truncate mt-n1">Regenerate package-lock.json (#29730)</div>
                                        </div>
                                        <div class="col-auto">
                                            <a href="#" class="list-group-item-actions">
                                                <?= $this->Icon->outline('star', ['class' => 'icon text-muted icon-2']) ?>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        <a href="#" class="btn btn-2 w-100"><?= __('Archive all') ?></a>
                                    </div>
                                    <div class="col">
                                        <a href="#" class="btn btn-2 w-100"><?= __('Mark all as read') ?></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
*/ ?>

<?php /*
                <!-- Alkalmazások (Apps Menu) -->
                <div class="nav-item dropdown d-none d-md-flex me-3">
                    <a href="#" class="nav-link px-0" data-bs-toggle="dropdown" tabindex="-1" aria-label="<?= __('Show app menu') ?>" data-bs-auto-close="outside" aria-expanded="false">
                        <?= $this->Icon->outline('apps', ['class' => 'icon icon-1']) ?>
                    </a>
                    <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-end dropdown-menu-card">
                        <div class="card">
                            <div class="card-header">
                                <div class="card-title"><?= __('My Apps') ?></div>
                                <div class="card-actions btn-actions">
                                    <a href="#" class="btn-action">
                                        <?= $this->Icon->outline('settings', ['class' => 'icon icon-1']) ?>
                                    </a>
                                </div>
                            </div>
                            <div class="card-body scroll-y p-2" style="max-height: 50vh">
                                <div class="row g-0">
                                    <div class="col-4">
                                        <a href="#" class="d-flex flex-column flex-center text-center text-secondary py-2 px-2 link-hoverable">
                                            <?= $this->Html->image('KvAdmin./static/brands/android.svg', ['class' => 'w-6 h-6 mx-auto mb-2', 'width' => 24, 'height' => 24, 'alt' => 'Android']) ?>
                                            <span class="h5">Android</span>
                                        </a>
                                    </div>
                                    <div class="col-4">
                                        <a href="#" class="d-flex flex-column flex-center text-center text-secondary py-2 px-2 link-hoverable">
                                            <?= $this->Html->image('KvAdmin./static/brands/facebook.svg', ['class' => 'w-6 h-6 mx-auto mb-2', 'width' => 24, 'height' => 24, 'alt' => 'Facebook']) ?>
                                            <span class="h5">Facebook</span>
                                        </a>
                                    </div>
                                    <div class="col-4">
                                        <a href="#" class="d-flex flex-column flex-center text-center text-secondary py-2 px-2 link-hoverable">
                                            <?= $this->Html->image('KvAdmin./static/brands/github.svg', ['class' => 'w-6 h-6 mx-auto mb-2', 'width' => 24, 'height' => 24, 'alt' => 'GitHub']) ?>
                                            <span class="h5">GitHub</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
*/ ?>
            </div>

            <?php if ($this->elementExists('topheader_user_menu')) : ?>
                <?= $this->element('topheader_user_menu') ?>
            <?php else: ?>
                <?= $this->element('KvAdmin.topheader_user_menu') ?>
            <?php endif; ?>

        </div>
    </div>
</header>