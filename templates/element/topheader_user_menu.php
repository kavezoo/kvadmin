            <!-- Felhasználói fiók / Menü -->
            <div class="nav-item dropdown">
                <a href="#" class="nav-link d-flex lh-1 p-0 px-2" data-bs-toggle="dropdown" aria-label="<?= __('Open user menu') ?>" aria-expanded="false">
                    <span class="avatar avatar-sm" style="background-image: url('<?= $this->Url->assetUrl('KvAdmin./static/avatars/000m.jpg') ?>')"></span>
                    <div class="d-none d-xl-block ps-2">
						<div><?= h(($currentUser->name ?? 'Jeff Shoemaker') . ' Plugin') ?></div>
                        <div class="mt-1 small text-secondary"><?= h($currentUser->role_title ?? __('Admin')) ?></div>
                    </div>
                </a>

				<div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
					<a href="#" class="dropdown-item d-flex align-items-center justify-content-between">
						<span><?= __('Status') ?></span>
						<?= $this->Icon->outline('activity', ['class' => 'icon text-muted ms-auto']) ?>
					</a>

					<?= $this->Html->link(
						'<span>' . __('Profile') . '</span>' . $this->Icon->outline('user', ['class' => 'icon text-muted ms-auto']),
						['controller' => 'Users', 'action' => 'login'],
						['escape' => false, 'class' => 'dropdown-item d-flex align-items-center justify-content-between']
					) ?>

					<a href="#" class="dropdown-item d-flex align-items-center justify-content-between">
						<span><?= __('Feedback') ?></span>
						<?= $this->Icon->outline('message-dots', ['class' => 'icon text-muted ms-auto']) ?>
					</a>

					<div class="dropdown-divider"></div>

					<?= $this->Html->link(
						'<span>' . __('Settings') . '</span>' . $this->Icon->outline('settings', ['class' => 'icon text-muted ms-auto']),
						['controller' => 'Users', 'action' => 'register'],
						['escape' => false, 'class' => 'dropdown-item d-flex align-items-center justify-content-between']
					) ?>

					<?= $this->Html->link(
						'<span>' . __('Change Password') . '</span>' . $this->Icon->outline('key', ['class' => 'icon text-muted ms-auto']),
						['controller' => 'Users', 'action' => 'change-password'],
						['escape' => false, 'class' => 'dropdown-item d-flex align-items-center justify-content-between']
					) ?>

					<?= $this->Html->link(
						'<span>' . __('Logout') . '</span>' . $this->Icon->outline('logout', ['class' => 'icon text-muted ms-auto']),
						['controller' => 'Users', 'action' => 'logout'],
						['escape' => false, 'class' => 'dropdown-item d-flex align-items-center justify-content-between']
					) ?>
				</div>
            </div>
