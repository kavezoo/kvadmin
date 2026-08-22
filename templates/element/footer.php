<?php
/**
 * Tabler Admin Footer Element
 * @var \App\View\AppView $this
 */
?>
<footer class="footer footer-transparent d-print-none mt-auto py-3 border-top">
    <div class="container-xl">
        <div class="row text-center align-items-center flex-row-reverse">
            <div class="col-lg-auto ms-lg-auto">
                <ul class="list-inline list-inline-dots mb-0">
                    <li class="list-inline-item">
                        <a href="[https://tabler.io](https://tabler.io)" target="_blank" class="link-secondary" rel="noopener">Tabler UI</a>
                    </li>
                    <li class="list-inline-item">
                        <a href="[https://book.cakephp.org/5/en/](https://book.cakephp.org/5/en/)" target="_blank" class="link-secondary" rel="noopener">CakePHP 5 Docs</a>
                    </li>
                </ul>
            </div>
            <div class="col-12 col-lg-auto mt-3 mt-lg-0">
                <ul class="list-inline list-inline-dots mb-0">
                    <li class="list-inline-item">
                        Copyright &copy; <?= date('Y') ?>
                        <a href="#" class="link-secondary"><?= h(env('APP_NAME', 'Admin Panel')) ?></a>.
                        Minden jog fenntartva.
                    </li>
                    <li class="list-inline-item">
                        v1.0.0
                    </li>
                </ul>
            </div>
        </div>
    </div>
</footer>