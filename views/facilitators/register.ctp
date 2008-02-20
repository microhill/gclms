<?= $this->renderElement('left_column'); ?>
<div class="gclms-center-column">
	<div class="gclms-content">
		<h1><?= __('Facilitator Application') ?></h1>    
		<p>
			<? __('You can apply here to become a facilitator for ').$group['name'] ?>. 
			<? __('You will later receive an e-mail indicating whether the group administrator approved you.') ?>
		</p>
		<?
		echo $form->create('Facilitator', array('action' => 'register'));
		
		echo '<div>';
			echo $form->submit(__('Apply',true),array('class'=>'Save','div'=>false));
			//echo $form->submit(__('Cancel',true),array('class'=>'Cancel','div'=>false));
		echo '</div>';
	
		echo $form->end();
		?>
		</div>
	</div>
</div>
<?= $this->renderElement('right_column'); ?>