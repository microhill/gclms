<div class="gclms-userbar">
	<?
	if(class_exists('User') && User::get('id')): ?>
		<?
		$alias = '<a href="/user/' . User::get('id') . '" class="gclms-user-alias" target="_top">' . User::get('username') . '</a>';
		$logout = '<a href="/users/logout" class="gclms-user-logout" target="_top">' . __('Logout',true) . '</a>';
		
		if($text_direction == 'ltr')
			echo $alias . $logout;
		else
			echo $logout . $alias;
		?>
	<? endif; ?>
</div>