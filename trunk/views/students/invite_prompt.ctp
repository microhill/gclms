<?
$javascript->link(array(
	'vendors/prototype1.6.0.3',
	'vendors/prototype_extensions1.0',
	'gclms',
	'popup'
), false);
?>
<div class="gclms-content">
	<h1><?= __('Invite Student?') ?></h1>    
		<?= $form->create('Student',array('id' => null,'url' => $groupAndCoursePath . '/students/invite')); ?>
		<?= $form->hidden('identifier'); ?>	
		<p><? echo sprintf(__('Student not found. Would you like to invite %s to join the class?',true),'<strong>' . $this->data['Student']['identifier'] . '</strong>') ?></p>
		<table class="gclms-buttons">
			<tr>
				<td><input type="submit" value="<? __('Yes') ?>" class="gclms-save" /></td>
				<td><button class="gclms-no" href="<?= $groupAndCoursePath ?>/students"><? __('No') ?></button></td>
			</tr>
		</table>
 		<?= $form->end(); ?>
	</div>
</div>