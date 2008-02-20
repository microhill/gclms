<?
//echo Security::hash(CAKE_SESSION_STRING . 'test');
?>

<div class="gclms-left-column">
	<div class="gclms-content">
		&nbsp;
	</div>
</div>

<div class="gclms-center-column">
	<div class="gclms-content">
		<div class="gclms-login">
		<h1><?= __('Login') ?></h1>    
			<?php $session->flash('Auth.login'); ?>
		    <?php echo $form->create('User', array('action' => 'login'));?>
		        <?php echo $form->input('username',array(
		        	'label' => array('text' => __("Username", true)),
		        	'between' => '<br/>'
		        ));?>
		        <?php echo $form->input('password',array(
		        	'label' => array('text' => __("Password", true)),
		        	'between' => '<br/>'
		        ));?>
		        <?php echo $form->submit('Login');?>
		    <?php echo $form->end(); ?>
		</div>
	</div>
</div>