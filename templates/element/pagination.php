<?php
/**
 * Tabler Pagination Element (Ellipzissel / pontokkal)
 * @var \App\View\AppView $this
 */

$this->Paginator->setTemplates([
    'number' => '<li class="page-item"><a class="page-link" href="{{url}}">{{text}}</a></li>',
    'current' => '<li class="page-item active"><a class="page-link" href="{{url}}">{{text}}</a></li>',
    // px-1 a szűk távolságért, inline-block + translateY a függőleges pozícióért
	'ellipsis' => '<li class="page-item disabled" style="margin: 0 2px;"><span class="page-link border-0 bg-transparent px-0" style="display:inline-block; transform: translateY(2px); width: 12px; margin-left: -12px; margin-right: -12px; letter-spacing: 1px; font-weight: bold;">...</span></li>',
    'first' => '<li class="page-item"><a class="page-link" href="{{url}}">' . $this->SystemIcon->sysIcon('first') . '</a></li>',
    'last' => '<li class="page-item"><a class="page-link" href="{{url}}">' . $this->SystemIcon->sysIcon('last') . '</a></li>',
    'prevActive' => '<li class="page-item"><a class="page-link" href="{{url}}">' . $this->SystemIcon->sysIcon('prev') . '</a></li>',
    'prevDisabled' => '<li class="page-item disabled"><a class="page-link" href="#" tabindex="-1" aria-disabled="true">' . $this->SystemIcon->sysIcon('prev') . '</a></li>',
    'nextActive' => '<li class="page-item"><a class="page-link" href="{{url}}">' . $this->SystemIcon->sysIcon('next') . '</a></li>',
    'nextDisabled' => '<li class="page-item disabled"><a class="page-link" href="#" tabindex="-1" aria-disabled="true">' . $this->SystemIcon->sysIcon('next') . '</a></li>',
]);

$paging = $this->Paginator->params();
if (!isset($paging['page']) || !isset($paging['pageCount'])) {
    foreach ($paging as $pagingData) {
        if (is_array($pagingData) && isset($pagingData['page'], $pagingData['pageCount'])) {
            $paging = $pagingData;
            break;
        }
    }
}

$pageCount = (int)($paging['pageCount'] ?? 1);
$requestedPage = (int)$this->getRequest()->getQuery('page', 0);
$paginatorCurrentPage = (int)($paging['page'] ?? 1);
$currentPage = $requestedPage > 0 ? $requestedPage : $paginatorCurrentPage;

if ($pageCount > 0) {
    $currentPage = max(1, min($currentPage, $pageCount));
} else {
    $currentPage = max(1, $currentPage);
}

$query = $this->getRequest()->getQueryParams();
unset($query['page']);

$buildPageUrl = static function (int $page) use ($query): string {
    return \Cake\Routing\Router::url(['?' => $query + ['page' => $page]]);
};

$renderPageLink = static function (int $page, int $currentPage, string $url): string {
    $isCurrent = $page === $currentPage;
    $class = $isCurrent ? 'page-item active' : 'page-item';

    return sprintf(
        '<li class="%s"><a class="page-link" href="%s">%d</a></li>',
        $class,
        h($url),
        $page
    );
};

$renderDisabledIcon = static function (string $icon): string {
    return sprintf(
        '<li class="page-item disabled"><a class="page-link" href="#" tabindex="-1" aria-disabled="true">%s</a></li>',
        $icon
    );
};

$modulus = 4;
$numbersToShow = [];

if ($pageCount > 0) {
    $numbersToShow[] = 1;

    $start = max(1, $currentPage - $modulus);
    $end = min($pageCount, $currentPage + $modulus);

    for ($page = $start; $page <= $end; $page++) {
        $numbersToShow[] = $page;
    }

    if ($pageCount > 1) {
        $numbersToShow[] = $pageCount;
    }
}

$numbersToShow = array_values(array_unique($numbersToShow));
sort($numbersToShow);
?>

<div class="card-body border-top py-3">
    <div class="d-flex align-items-center">
        <p class="m-0 text-secondary">
            <?= $this->Paginator->counter(__('Megjelenítve: {{start}} - {{end}} / {{count}} találat')) ?>
        </p>
        <?php if ($pageCount > 1): ?>
        <ul class="pagination m-0 ms-auto">
            <?php if ($currentPage > 1): ?>
                <li class="page-item"><a class="page-link" href="<?= h($buildPageUrl(1)) ?>"><?= $this->SystemIcon->sysIcon('first') ?></a></li>
                <li class="page-item"><a class="page-link" href="<?= h($buildPageUrl($currentPage - 1)) ?>"><?= $this->SystemIcon->sysIcon('prev') ?></a></li>
            <?php else: ?>
                <?= $renderDisabledIcon($this->SystemIcon->sysIcon('first')) ?>
                <?= $renderDisabledIcon($this->SystemIcon->sysIcon('prev')) ?>
            <?php endif; ?>

            <?php
            $previousNumber = null;
            foreach ($numbersToShow as $page):
                if ($previousNumber !== null && $page > ($previousNumber + 1)):
                    ?>
                    <li class="page-item disabled" style="margin: 0 2px;"><span class="page-link border-0 bg-transparent px-0" style="display:inline-block; transform: translateY(2px); width: 12px; margin-left: -12px; margin-right: -12px; letter-spacing: 1px; font-weight: bold;">...</span></li>
                    <?php
                endif;

                echo $renderPageLink($page, $currentPage, $buildPageUrl($page));
                $previousNumber = $page;
            endforeach;
            ?>

            <?php if ($currentPage < $pageCount): ?>
                <li class="page-item"><a class="page-link" href="<?= h($buildPageUrl($currentPage + 1)) ?>"><?= $this->SystemIcon->sysIcon('next') ?></a></li>
                <li class="page-item"><a class="page-link" href="<?= h($buildPageUrl($pageCount)) ?>"><?= $this->SystemIcon->sysIcon('last') ?></a></li>
            <?php else: ?>
                <?= $renderDisabledIcon($this->SystemIcon->sysIcon('next')) ?>
                <?= $renderDisabledIcon($this->SystemIcon->sysIcon('last')) ?>
            <?php endif; ?>
        </ul>
        <?php endif; ?>
    </div>
</div>