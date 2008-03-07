<div class="gclms-userbar">
	<? if(!empty($user)): ?>
		<a href="/profile ?>" class="gclms-user-alias" target="_top"><?= $user['alias'] ?></a>
		<a href="/users/logout" class="gclms-user-logout" target="_top"><? __('Logout') ?></a>
	<? endif; ?>
</div>