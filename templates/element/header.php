<header class="navbar-expand-md">
    <div class="collapse navbar-collapse" id="navbar-menu">
        <div class="navbar">
            <div class="container-xl">
                <div class="d-flex flex-column flex-md-row flex-fill align-items-stretch align-items-md-center">
                    
                    <!-- ========================================================= -->
                    <!-- 1. BAL OLDALRA IGAZÍTOTT MENÜCSOPORT                     -->
                    <!-- ========================================================= -->
                    <ul class="navbar-nav">
                        
                        <!-- Home -->
                        <li class="nav-item active">
                            <?= $this->Html->link(
                                '<span class="nav-link-icon d-md-none d-lg-inline-block">' . $this->Icon->outline('home') . '</span>' .
                                '<span class="nav-link-title">' . __('Home') . '</span>',
                                '/' . $prefix,
                                ['escape' => false, 'class' => 'nav-link']
                            ) ?>
                        </li>

                        <!-- Interface (Teljes almenülista 2 oszlopban + Authentication al-dropdownnal) -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#navbar-base" data-bs-toggle="dropdown" data-bs-auto-close="outside" role="button" aria-expanded="false">
                                <span class="nav-link-icon d-md-none d-lg-inline-block">
                                    <?= $this->Icon->outline('package') ?>
                                </span>
                                <span class="nav-link-title"><?= __('Interface') ?></span>
                            </a>
                            <div class="dropdown-menu">
                                <div class="dropdown-menu-columns">
                                    <div class="dropdown-menu-column">
                                        <?= $this->Html->link(
                                            __('Accordion') . ' <span class="badge badge-sm bg-green-lt text-uppercase ms-auto">' . __('New') . '</span>',
                                            ['controller' => 'Pages', 'action' => 'display', 'accordion'],
                                            ['escape' => false, 'class' => 'dropdown-item']
                                        ) ?>
                                        <?= $this->Html->link(__('Alerts'), ['controller' => 'Pages', 'action' => 'display', 'alerts'], ['class' => 'dropdown-item']) ?>
                                        <?= $this->Html->link(__('Alerts 2'), ['controller' => 'Pages', 'action' => 'display', 'alerts'], ['class' => 'dropdown-item']) ?>
                                        <?= $this->Html->link(__('Alerts 3'), ['controller' => 'Pages', 'action' => 'display', 'alerts'], ['class' => 'dropdown-item']) ?>
                                        <?= $this->Html->link(__('Alerts 4'), ['controller' => 'Pages', 'action' => 'display', 'alerts'], ['class' => 'dropdown-item']) ?>
                                        
                                        <!-- Authentication al-dropdown -->
                                        <div class="dropend">
                                            <a class="dropdown-item dropdown-toggle" href="#sidebar-authentication" data-bs-toggle="dropdown" data-bs-auto-close="outside" role="button" aria-expanded="false">
                                                <?= __('Authentication') ?>
                                            </a>
                                            <div class="dropdown-menu">
                                                <?= $this->Html->link(__('Sign in'), ['prefix' => 'Admin', 'controller' => 'Users', 'action' => 'login'], ['class' => 'dropdown-item']) ?>
                                                <?= $this->Html->link(__('Sign up'), ['prefix' => 'Admin', 'controller' => 'Users', 'action' => 'register'], ['class' => 'dropdown-item']) ?>
                                                <?= $this->Html->link(__('Forgot password'), ['prefix' => 'Admin', 'controller' => 'Users', 'action' => 'forgotPassword'], ['class' => 'dropdown-item']) ?>
                                                <?= $this->Html->link(__('Terms of service'), ['controller' => 'Pages', 'action' => 'display', 'terms'], ['class' => 'dropdown-item']) ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="dropdown-menu-column">
                                        <?= $this->Html->link(
                                            __('Segmented control') . ' <span class="badge badge-sm bg-green-lt text-uppercase ms-auto">' . __('New') . '</span>',
                                            ['controller' => 'Pages', 'action' => 'display', 'segmented-control'],
                                            ['escape' => false, 'class' => 'dropdown-item']
                                        ) ?>
                                        <?= $this->Html->link(__('Social icons'), ['controller' => 'Pages', 'action' => 'display', 'social-icons'], ['class' => 'dropdown-item']) ?>
                                    </div>
                                </div>
                            </div>
                        </li>

                        <!-- Plugins (Teljes almenülista) -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#navbar-plugins" data-bs-toggle="dropdown" data-bs-auto-close="outside" role="button" aria-expanded="false">
                                <span class="nav-link-icon d-md-none d-lg-inline-block">
                                    <?= $this->Icon->outline('puzzle') ?>
                                </span>
                                <span class="nav-link-title"><?= __('President') ?></span>
                            </a>
                            <div class="dropdown-menu">
                                <?= $this->Html->link(__('Competitons'), ['controller' => 'Competitions', 'action' => 'index'], ['class' => 'dropdown-item']) ?>
                                <?= $this->Html->link(__('Competitions Users'), ['controller' => 'CompetitionsUsers', 'action' => 'index'], ['class' => 'dropdown-item']) ?>
                                <?= $this->Html->link(__('Clubs'), ['controller' => 'Clubs', 'action' => 'index'], ['class' => 'dropdown-item']) ?>
                                <?= $this->Html->link(__('Dropzone'), ['controller' => 'Plugins', 'action' => 'index'], ['class' => 'dropdown-item']) ?>
                                <?= $this->Html->link(__('Fullcalendar'), ['controller' => 'Plugins', 'action' => 'index'], ['class' => 'dropdown-item']) ?>
                            </div>
                        </li>
                    </ul>

                    <!-- ========================================================= -->
                    <!-- 2. JOBB OLDALRA IGAZÍTOTT MENÜCSOPORT (Help + Settings)   -->
                    <!-- ========================================================= -->
                    <ul class="navbar-nav ms-md-auto">
                        <!-- Help -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#navbar-help" data-bs-toggle="dropdown" data-bs-auto-close="outside" role="button" aria-expanded="false">
                                <span class="nav-link-icon d-md-none d-lg-inline-block">
                                    <?= $this->Icon->outline('lifebuoy') ?>
                                </span>
                                <span class="nav-link-title"><?= __('Help') ?></span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <?= $this->Html->link(__('Templates'), 'https://tabler.io/docs', ['class' => 'dropdown-item', 'target' => '_blank', 'rel' => 'noopener']) ?>
                                <?= $this->Html->link(__('Changelog'), ['controller' => 'Pages', 'action' => 'display', 'changelog'], ['class' => 'dropdown-item']) ?>
                                <?= $this->Html->link(__('Source code'), 'https://github.com/tabler/tabler', ['class' => 'dropdown-item', 'target' => '_blank', 'rel' => 'noopener']) ?>
                                <?= $this->Html->link(
                                    $this->Icon->outline('heart', ['class' => 'icon icon-inline me-1']) . __('Sponsor project!'),
                                    'https://github.com/sponsors/codecalm',
                                    ['escape' => false, 'class' => 'dropdown-item text-pink', 'target' => '_blank', 'rel' => 'noopener']
                                ) ?>
                            </div>
                        </li>

                        <!-- Theme Settings -->
                        <li class="nav-item">
                            <a class="nav-link d-flex align-items-center" href="#" data-bs-toggle="offcanvas" data-bs-target="#offcanvasSettings">
                                <span class="nav-link-icon d-md-none d-lg-inline-block">
                                    <?= $this->Icon->outline('settings') ?>
                                </span>
                                <span class="nav-link-title"><?= __('Theme Settings') ?></span>
                                <span class="badge badge-sm bg-red text-red-fg ms-2"><?= __('New') ?></span>
                            </a>
                        </li>
                    </ul>

                </div>
            </div>
        </div>
    </div>
</header>

<?php
// A JS scriptblockra szükség van, ha azt szeretnéd, hogy dropdown lenyitásakor 
// az eredetileg aktív menüpontról lekerüljön a szürke háttér és a fekete szín:
$this->Html->scriptBlock(
    "
    document.addEventListener('DOMContentLoaded', function () {
        const navbar = document.querySelector('.navbar-nav');
        if (!navbar) return;

        document.addEventListener('show.bs.dropdown', function () {
            navbar.classList.add('has-dropdown-open');
        });

        document.addEventListener('hidden.bs.dropdown', function () {
            setTimeout(function () {
                if (!navbar.querySelector('.dropdown-menu.show')) {
                    navbar.classList.remove('has-dropdown-open');
                }
            }, 50);
        });
    });
    ",
    ['block' => 'script']
);
?>