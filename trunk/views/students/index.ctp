<?
$html->css('students', null, null, false);

$javascript->link(array(
	'vendors/prototype1.6.0.3',
	'vendors/prototype_extensions1.0',
	'gclms',
	'popup',
	//'students'
), false);

$primary_column = $this->element('primary_column');
$secondary_column = ''; //$this->element('../class/secondary_column');

echo $this->element('left_column',array(
	'primary_column' => $primary_column
));
?>
	
<div class="gclms-center-column">
	<div class="gclms-content">
		<h1><? __('Students') ?></h1>
		<form action="<?= $groupAndCoursePath ?>/students/" method="post">
			<table class="gclms-buttons">
				<tr>
					<td><button href="<?= $groupAndCoursePath ?>/students/add"><? __('Add') ?></button></td>
					<td><button href="<?= $groupAndCoursePath ?>/students/invite"><? __('Invite') ?></button></td>
					<? if(!empty($enrollees) || !empty($invitations)): ?><td><button class="gclms-delete-students"><? __('Remove') ?></button></td><? endif; ?>
				</tr>
			</table>
			<? if(!empty($enrollees) || !empty($invitations)): ?>
				<table class="gclms-tabular" cellspacing="0" id="gclms-students">
					<tr>
						<th style="width: 1px;">
							<input type="checkbox" id="gclms-select-all" />
						</th>
						<th>
							<? __('Name') ?>
						</th>
					<tbody>
						<?
						$totalPoints = 0;
						foreach($enrollees as $enrollee) {
							?>
							<tr>
								<td>
									<input type="checkbox" class="gclms-Student-select" name="data[Students][]" value="<?= $enrollee['ClassEnrollee']['id'] ?>" />
								</td>
								<td>
									<?= $enrollee['User']['username'] ?>
								</td>
							</tr>
							<?
						}
						?>

						<? if(!empty($invitations)): ?>
							<?
							foreach($invitations as $invitation) {
								?>
								<tr>
									<td>
										<input type="checkbox" class="gclms-student-select" name="data[Students][]" value="<?= $invitation['ClassInvitation']['id'] ?>" />
									</td>
									<td style="white-space: nowrap;">
										<?= $invitation['ClassInvitation']['identifier'] ?> (<? __('invited') ?>)
									</td>
								</tr>
								<?
							}
							?>
						<? endif; ?>
					</tbody>
				</table>
			<? endif; ?>
		</form>
	</div>
</div>

<?= $this->element('right_column',array(
	'primary_column' => $primary_column
));?>