<? include 'views/install/left_column.ctp'; ?>

<div class="gclms-center-column">
<?= $form->create(null, array('url' => '/install/first_user')); ?>
	<div class="gclms-content" id="Database">
		<h1><? __('First User') ?></h2>
		
		<?
		echo $form->input('User/username',array(
			'label' =>  __('Username', true),
			'between' => '<br/>'
		));
		echo $form->input('User/password',array(
			'label' =>  __('Password', true),
			'type' => 'password',
			'between' => '<br/>'
		));
		echo $form->input('User/first_name',array(
			'label' =>  __('First Name', true),
			'between' => '<br/>'
		));
		echo $form->input('User/last_name',array(
			'label' =>  __('Last Name', true),
			'between' => '<br/>'
		));
		echo $form->input('User/email',array(
			'label' =>  __('Email', true),
			'between' => '<br/>'
		));
		echo $form->submit(__('Next',true),array('class'=>'Next'));
		?>
	</div>
<?= $form->end(); ?>
</div>