<div class="gclms-content">
	<div class="gclms-basic-info">
		<img src="<?= $userDisplay->getAvatarImage($user) ?>" />
		<div class="gclms-display-name"><?= $userDisplay->getDisplayName($user) ?></div>
		<div class="gclms-location">
			<?
			if(!empty($user['User']['city']))
				echo $user['User']['city'];				

			if(!empty($user['User']['city']) && !empty($user['User']['state']))
				echo ', ';

			if(!empty($user['User']['state']))
				echo $user['User']['state'];

			if(!empty($user['User']['state']) && !empty($user['User']['country']))
				echo ', ';
				
			if(!empty($user['User']['country']))
				echo $user['User']['country'];
			?>
		</div>
		<!-- div class="gclms-joined"><?= sprintf(__('Joined: %s',true),date('F j, Y',strtotime($user['User']['created']))) ?></div -->

	</div>
</div>