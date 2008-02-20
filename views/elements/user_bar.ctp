<div class="gclms-logout">
	<?
	if(!empty($user))
		echo $html->link(__('Logout',true),array('controller'=>'users','action'=>'logout'),array('target'=>'_top'));
	?>
</div>