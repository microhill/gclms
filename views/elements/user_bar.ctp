<div class="gclms-userbar">
	<? if(!empty($user)): ?>
		<?
		$alias = '<a href="/user/' . $user['id'] . '" class="gclms-user-alias" target="_top">' . $user['alias'] . '</a>';
		$logout = '<a href="/users/logout" class="gclms-user-logout" target="_top">' . __('Logout',true) . '</a>';
		
		if($text_direction == 'ltr')
			echo $alias . $logout;
		else
			echo $logout . $alias;
		?>
	<? endif; ?>
</div>