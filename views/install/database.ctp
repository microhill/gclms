<? include 'views/install/left_column.ctp'; ?>

<div class="gclms-center-column">
<?= $form->create(null, array('action' => 'database')); ?>
	<div class="gclms-content" id="Database">
		<h1><? __('Database Configuration') ?></h2>
		
		<?
		echo $form->input('Database.host',array(
			'label' =>  __('Host', true),
			'between' => '<br/>'
		));
		echo $form->input('Database.username',array(
			'label' =>  __('Username', true),
			'between' => '<br/>'
		));
		echo $form->input('Database.password',array(
			'label' =>  __('Password', true),
			'between' => '<br/>',
			'type' => 'password'
		));
		echo $form->input('Database.database',array(
			'label' =>  __('Database (must exist)', true),
			'between' => '<br/>'
		));

		echo $form->submit(__('Next',true),array('class'=>'gclms-next'));
		?>
	</div>
<?= $form->end(); ?>
</div>
