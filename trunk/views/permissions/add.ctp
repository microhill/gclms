<?
$html->css('permissions', null, null, false);

$javascript->link(array(
	'vendors/prototype1.6.0.3',
	'vendors/prototype_extensions1.0',
	'gclms',
	'permissions'
), false);
?>
<div class="gclms-content">
	<?= $this->element('notifications'); ?>
	<div class="gclms-step-back"><a href="/<?= Group::get('web_path') ?>/permissions"><? __('Cancel and go back') ?></a></div>
	
	<h1>
		<? __('Add Permissions to User') ?>
	</h1>

	<?= $form->create('User',array('url' => '/' . Group::get('web_path') . '/permissions/add')) ?>
	
	<div id="gclms-user-search" class="<? if(!empty($this->data['User'])): ?>gclms-hidden<? endif; ?>">
		<?= $form->input('User.search_name',array(
			'label' => 'Username or e-mail',
			'between' => '<br/>'
		)) ?>
		<table>
			<tbody>
				<tr>
					<td><?= $form->submit('Search',array(
							'div' => false
						)); ?>						
					</td>
					<td>
						<?= $form->button('Cancel',array(
							'id' => 'gclms-cancel-change-user',
							'class' => 'gclms-hidden',
							'div' => false
				 		)); ?>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
	
	<?= $form->end() ?>
	
	<?= $form->create('Permission',array('url' => $groupAndCoursePath . '/permissions/add')) ?>
	
	<? include('form.ctp') ?>
	<?= $form->submit('Save',array(
		'class' => empty($this->data['User']) ? 'gclms-hidden' : '',
		'id' => 'gclms-save-button'
	)) ?>
	<?= $form->end() ?>
</div>