<?
$html->css('gradebook', null, null, false);

$javascript->link(array(
	'vendors/prototype1.6.0.3',
	'vendors/prototype_extensions1.0',
	'gclms',
	'popup',
	'gradebook'
), false);

$primary_column = $this->element('primary_column');
$secondary_column = ''; //$this->element('../class/secondary_column');

echo $this->element('left_column',array(
	'primary_column' => $primary_column
));
?>
	
<div class="gclms-center-column">
	<div class="gclms-content">
		<h1><? __('Gradebook') ?></h1>
		<table class="gclms-buttons">
			<tr>
				<td><button href="<?= $groupAndCoursePath ?>/assignments/add"><? __('Add assignment') ?></button></td>
			</tr>
		</table>
		<? if(!empty($assignments)): ?>
			<table class="gclms-tabular" cellspacing="0" id="gclms-gradebook">
				<tbody>
					<tr>
						<th>&nbsp;</th>
						<td rowspan="<?= sizeof($assignments) + 1 ?>" valign="top" class="gclms-students">
							<table>
								<tbody>
									<tr>
										<? foreach($enrollees as $student): ?>
											<th>
												<?= $student['User']['username'] ?>
											</th>
										<? endforeach; ?>
									</tr>
									<? foreach($assignments as $assignment): ?>
										<tr>
											<? foreach($enrollees as $student): ?>
												<?
												$grade = Set::extract('/User/ClassGrade[assignment_id=' . $assignment['Assignment']['id'] . ']',$student);
												?>
												<td class="gclms-grade" gclms-grade-value="<? if($grade) echo $grade[0]['ClassGrade']['points']; ?>">
												<?
												if($grade) {
													echo $grade[0]['ClassGrade']['points'];												
												} else {
													echo '&nbsp;';													
												}
												?>
												</td>
											<? endforeach; ?>											
										</tr>
									<? endforeach; ?>
								</tbody>
							</table>
						</td>
					</tr>
					<?
					foreach($assignments as $assignment) {
						?>
						<tr>
							<th>
								<?= $assignment['Assignment']['title'] ?>
							</th>
						</tr>
						<?
					}
					?>
				</tbody>
			</table>
		<? endif; ?>
	</div>
</div>

<?= $this->element('right_column',array(
	'primary_column' => $primary_column
));?>