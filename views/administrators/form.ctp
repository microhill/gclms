<? if(!empty($this->data['User'])): ?>
	<?= $form->hidden('User.id') ?>
	<div id="gclms-user">
		<img src="http://www.gravatar.com/avatar.php?gravatar_id=<?= md5($this->data['User']['email']) ?>&default=<?= urlencode(@$default) ?>&size=96" style="float:left;margin-right: 10px;margin-bottom: 10px;" />
		<h2><?= $this->data['User']['username'] ?></h2>
		<div><em><?= $this->data['User']['email'] ?></em></div>
		<? if($this->action == 'add'): ?>
			<p><button id="gclms-change-user"><? __('Change') ?></button></p>
		<? endif; ?>
	</div>
<? endif; ?>

<div id="gclms-user-permissions" class="<? if(empty($this->data['User'])): ?>gclms-hidden<? endif; ?>" style="clear: both;">
	<p>
		<?= $form->input('site_administrator',array(
			'label' => 'Site Administrator',
			'type' => 'checkbox',
			'between' => ' ',
			'name' => 'data[SiteAdministrator]',
			'checked' => @$this->data['SiteAdministrator']
		)) ?>
	</p>
	
	<h2>Groups Administrating</h2>
	<?
	foreach($groups_administering as $group_id => $group) {
		unset($groups[$group_id]);
	}
	?>

	<?
	if(!empty($groups)): ?>
		<div id="gclms-group-selection">
			<table class="gclms-buttons">
				<tr>
					<td>
						<?
						echo $form->input('Group.selection',array(
							'options' => $groups,
							'div' => false,
							'label' => false,
							'id' => 'gclms-unselected-groups',
							'name' => ''
						));
						?>
					</td>
					<td>
						<button id="gclms-add-group"><? __('Add Group') ?></button>
					</td>
				</tr>
			</table>
		</div>
	<? endif; ?>

	<div id="gclms-groups">
		<?
		if(!empty($groups_adminstering)) {
			foreach($groups_adminstering as $group_id => $group) {
				echo $this->element('../permissions/group_permissions',array(
					'group_title' => $groups[$group_id],
					'group_id' => $group_id
				));
			}	
		}
		?>
	</div>

	<? if(!empty($classes)): ?>
		<h2>Specific Class Permissions</h2>
		<p>
			<? echo $form->input('Class.selection',array(
				'options' => $classes,
				'div' => false,
				'label' => false,
				'id' => 'gclms-class-selection'
			));
			?><button id="gclms-add-class"><? __('Add Class') ?></button>	
		</p>
	<? endif; ?>
</div>

<script>
var tmpGroupAdministratorView = <?= $javascript->object(str_replace(array("\n","\r","\t",'    '),'',$this->element('../administrators/group_administrator',array(
	'group_name' => '#{group_title}',
	'group_id' => '#{group_id}'
)))); ?>;
</script>