<?
echo $this->element('no_column_background');

$html->css('permissions', null, null, false);
?>
<div class="gclms-content">
	<?= $this->element('notifications'); ?>
	<h1>
		Edit permissions for %
	</h1>
	
	<?
	$courses2 = Set::extract($this->data['Permissions'],'{n}.Permission.course_id');
	pr($this->data['Permissions']);
	?>
	
	<? include('form.ctp') ?>
</div>