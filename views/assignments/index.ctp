<?
$javascript->link(array(
	'vendors/prototype1.6.0.3',
	'vendors/prototype_extensions1.0',
	'gclms'
), false);

$primary_column = $this->element('class_menu');
$secondary_column = ''; //$this->element('../class/secondary_column');

echo $this->element('left_column',array(
	'primary_column' => $primary_column,
	'secondary_column' => $secondary_column
));
?>
	
<div class="gclms-center-column">
	<div class="gclms-content">
		<h1><? __('Assignments') ?></h1>
		<button href="assignments/add"><? __('Add') ?></button>
		<?
		//pr($announcments);
		?>
		
	</div>
</div>

<?= $this->element('right_column',array(
	'primary_column' => $primary_column,
	'secondary_column' => $secondary_column
));?>