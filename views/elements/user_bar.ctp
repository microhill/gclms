<div class="gclms-userbar">
	<?
	if(class_exists('User') && User::get('id')): ?>
		<?
		$username = '<a href="/user/' . User::get('id') . '" class="gclms-user-username" target="_top">' . User::get('username') . '</a>';
		$logout = '<a href="/users/logout" class="gclms-user-logout" target="_top">' . __('Logout',true) . '</a>';
		
		if($text_direction == 'ltr')
			echo $username . $logout;
		else
			echo $logout . $username;
		?>
	<? endif; ?>
</div>