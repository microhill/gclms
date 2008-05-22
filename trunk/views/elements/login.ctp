<div class="gclms-login gclms-wrapper">
	<?php $session->flash('Auth.login'); ?>
    <?= $form->create('User', array('url' => '/users/login','id'=>'UserLogin'));?>
        <?= $form->input('email',array(
        	'label' => array('text' => __("E-mail, Student ID, or OpenID", true)),
        	'between' => '<br/>'
        ));?>
        <?= $form->input('password',array(
        	'label' => array('text' => __("Password", true)),
        	'between' => '<br/>',
        	'type' => 'password',
			'div' => array('id' => 'UserPasswordDiv')
        ));?>
        <?
        echo $form->submit(__('Login',true));
        ?>
	    <div class="gclms-forgot-login"><a href="/users/reset_password"><? __('Forgot your login information?') ?></a></div>
	    <div class="gclms-forgot-login"><a href="/register"><? __('New student?') ?></a></div>
        <?
        echo $form->end();
		?>
</div>