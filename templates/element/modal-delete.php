<!-- Tabler Delete Confirmation Modal -->
<div class="modal modal-blur fade" id="delete-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
        <div class="modal-content">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            <div class="modal-status bg-danger"></div>
            <div class="modal-body text-center py-4">

				<span class="text-danger mb-2 d-inline-block icon-lg" style="width: 80px; height: 80px;">
					<?= $this->SystemIcon->modalIcon('alert') ?>
				</span>
				
                <h3><?= __('Biztosan törölni szeretnéd?') ?></h3>
                <div class="text-secondary" id="modal-delete-text">
                    <?= __('Valóban törölni szeretnéd a(z)') ?><br><strong id="modal-delete-item-name" class="text-body"></strong><br><?= __('elemet?') ?><br>
                    <small class="text-muted"><?= __('A művelet nem vonható vissza.') ?></small>
                </div>
            </div>
            <div class="modal-footer">
                <div class="w-100">
                    <div class="row">
                        <div class="col">
                            <button type="button" class="btn w-100" data-bs-dismiss="modal">
                                <?= __('Mégse') ?>
                            </button>
                        </div>
                        <div class="col">
                            <!-- CakePHP POST Form a biztonságos törléshez -->
                            <?= $this->Form->create(null, ['id' => 'modal-delete-form', 'method' => 'post']) ?>
                                <button type="submit" class="btn btn-danger w-100">
                                    <?= __('Törlés') ?>
                                </button>
                            <?= $this->Form->end() ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->Html->scriptStart(['block' => true]); ?>
document.addEventListener('DOMContentLoaded', function () {
    const deleteModal = document.getElementById('delete-modal');
    if (deleteModal) {
        deleteModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const url = button.getAttribute('data-url');
            const name = button.getAttribute('data-name');

            // Form action beállítása
            const form = deleteModal.querySelector('#modal-delete-form');
            if (form && url) {
                form.setAttribute('action', url);
            }

            // Név beillesztése
            const nameContainer = deleteModal.querySelector('#modal-delete-item-name');
            if (nameContainer) {
                nameContainer.textContent = name ? '"' + name + '"' : '';
            }
        });
    }
});
<?php $this->Html->scriptEnd(); ?>
