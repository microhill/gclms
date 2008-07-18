<?
$column_elements = array(
	'primary' => 'course_description',
	'secondary' => 'course_description'
);

echo $this->element('left_column',array(
	'column_elements' => $column_elements
)); ?>
		
<div class="gclms-center-column">
	<div class="content">	
		<? include('table.ctp'); ?>	
	</div>
</div>

<?= $this->element('right_column',array(
	'column_elements' => $column_elements
)); ?>