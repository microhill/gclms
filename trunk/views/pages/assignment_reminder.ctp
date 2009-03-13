<h3>Reminder: <?= $assignment['Assignment']['title'] ?></h3>
<? if(!VirtualClass::get('id') && !empty($assignment['Assignment']['due_date'])): ?>
	<p><?= sprintf(__('Due: Week %s, day %s',true),$assignment['Assignment']['due_date_week'],$assignment['Assignment']['due_date_day']) ?></p>
<? elseif(VirtualClass::get('id') && !empty($assignment['Assignment']['due_date'])): ?>
	<p><?= sprintf(__('Due: Week %s, day %s',true),$assignment['Assignment']['due_date_week'],$assignment['Assignment']['due_date_day']) ?></p>
<? endif; ?>
<p><?= $assignment['Assignment']['description'] ?></p>
<? if(!empty($assignment['AssignmentAssociation'])): ?>
<ul>
	<? foreach($assignment['AssignmentAssociation'] as $assignmentAssociation): ?>
		<?
		if($assignmentAssociation['model'] == 'Page') {
			$link = 'pages';
		} else if($assignmentAssociation['model'] == 'Forum') {
			$link = 'forums';			
		}
		?>
		<li><a href="<?= $groupAndCoursePath ?>/<?= $link ?>/view/<?= $assignmentAssociation['foreign_key'] ?>"><?= $assignmentAssociation['title'] ?></a></li>
	<? endforeach; ?>
</ul>
<? endif; ?>