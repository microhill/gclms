<div class="gclms-userbar">
	<? if(!empty($user)): ?>
		<?
		$alias = '<a href="/profile" class="gclms-user-alias" target="_top">' . $user['alias'] . '</a>';
		$logout = '<a href="/users/logout" class="gclms-user-logout" target="_top">' . __('Logout',true) . '</a>';
		
		echo text_direction($alias,$logout);
		?>
	<? endif; ?>
</div>