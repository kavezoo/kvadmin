<?php
/**
 * @var \App\View\AppView $this
 * @var array $params
 * @var string $message
 */
$class = 'message';
if (!empty($params['class'])) {
    $class .= ' ' . $params['class'];
}
if (!isset($params['escape']) || $params['escape'] !== false) {
    $message = h($message);
}
?>

					<div class="alert alert-danger alert-dismissible" role="alert">
						<div class="alert-icon">
							<?= $this->Icon->outline("refresh-alert") ?>
							<?php //= $this->Icon->outline("exclamation-mark") ?>
						</div>
						<div>
							<h4 class="alert-heading"><?= __("Error") ?></h4>
							<div class="alert-description">
								<?= $message ?>
							</div>
						</div>
						<a class="btn-close" data-bs-dismiss="alert" aria-label="close" style="transform: scale(1.4); transform-origin: center;"></a>
					</div>
