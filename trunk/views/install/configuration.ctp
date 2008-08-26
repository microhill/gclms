<? include 'views/install/left_column.ctp'; ?>

<div class="gclms-center-column">
<?= $form->create(null, array('url' => '/install/configuration')); ?>
	<div class="gclms-content" id="Database">
		<h1><? __('Site Configuration') ?></h2>
		
		<?
		echo $form->input('App.name',array(
			'label' =>  __('Site Name', true),
			'between' => '<br/>'
		));
		
		echo $form->input('App.domain',array(
			'label' =>  __('Domain', true),
			'between' => '<br/>'
		));
		
		echo $form->submit(__('Next',true),array('class'=>'Next'));
		?>
	</div>
<?= $form->end(); ?>
</div>