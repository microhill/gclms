<?
$html->css('assignments', null, null, false);

$javascript->link(array(
	'vendors/prototype1.6.0.3',
	'vendors/prototype_extensions1.0',
	'gclms',
	'popup',
	'assignments'
), false);

$primary_column = $this->element('primary_column');
$secondary_column = ''; //$this->element('../class/secondary_column');

echo $this->element('left_column',array(
	'primary_column' => $primary_column
));
?>
	
<div class="gclms-center-column">
	<div class="gclms-content">
		<h1><? VirtualClass::get('id') ? __('Assignments') : __('Default Assignments') ?></h1>
		<form action="<?= $groupAndCoursePath ?>/assignments/" method="post">
			<table class="gclms-buttons">
				<tr>
					<td><button href="<?= $groupAndCoursePath ?>/assignments/add"><? __('Add') ?></button></td>
					<? if(!empty($this->data)): ?><td><button class="gclms-delete-assignments"><? __('Delete') ?></button></td><? endif; ?>
				</tr>
			</table>
			<? if(!empty($this->data)): ?>
				<table class="gclms-tabular" cellspacing="0" id="gclms-files">
					<tr>
						<th style="width: 1px;">
							<input type="checkbox" id="gclms-select-all" />
						</th>
						<th>
							<? __('Name') ?>
						</th>
						<th style="width: 1px;white-space:nowrap;">
							<? __('Due day') ?>
						</th>
						<th style="width: 1px;white-space:nowrap;">
							<? __('Point value') ?>
						</th>
					</tr>
					<tbody>
						<?
						$totalPoints = 0;
						foreach($this->data as $assignment) {
							?>
							<tr>
								<td>
									<input type="checkbox" class="gclms-assignment-select" name="data[Assignments][]" value="<?= $assignment['Assignment']['id'] ?>" />
								</td>
								<td>
									<a href="assignments/edit/<?= $assignment['Assignment']['id'] ?>" class="gclms-assignment-title"><?= $assignment['Assignment']['title'] ?></a><br/>
									<?= $assignment['Assignment']['description'] ?>
								</td>
								<td style="white-space: nowrap;">
									<? 
									pr($assignment);
									
									if($assignment['Assignment']['due_date']): ?>
										<? __('Week') ?> <?= $assignment['Assignment']['due_date_week'] ?>,
										<? __('day') ?> <?= $assignment['Assignment']['due_date_day'] ?>
									<? endif;?>
								</td>
								<td>
									<?
									echo $assignment['Assignment']['points'];
									$totalPoints += $assignment['Assignment']['points'];
									?>
								</td>
							</tr>
							<?
						}
						?>
						<tr>
							<td></td>
							<td></td>
							<td></td>
							<td><?= $totalPoints ?> <? __('(total)') ?></td>
						</tr>
					</tbody>
				</table>
			<? endif; ?>
		</form>
	</div>
</div>

<?= $this->element('right_column',array(
	'primary_column' => $primary_column
));?>