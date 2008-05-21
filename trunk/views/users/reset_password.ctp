<?= $this->element('no_column_background'); ?>
<div class="gclms-center-column">
	<div class="gclms-content">
		<?
		echo $this->element('notifications');
		?>
		<div class="gclms-login">
			<h2><?= __('Reset Your Password') ?></h2>    
			<?php $session->flash('Auth.login'); ?>
		    <?= $form->create('User', array('url' => '/users/reset_password','id'=>'UserLogin'));?>
		        <?= $form->input('username',array(
		        	'label' => array('text' => __("Username", true)),
		        	'between' => '<br/>'
		        ));?>
		        <p><?= __('A new password will be sent to your e-mail address.') ?></p>
		        <?
		        echo $form->submit('Reset');
		        
		        echo $form->end();
		        ?>
		</div>
	</div>
</div>