<?
$javascript->link(array(
	'vendors/prototype1.6.0.3',
	'vendors/prototype_extensions1.0',
	'gclms'
), false);

$primary_column = $this->element('primary_column');
$secondary_column = $this->element('secondary_column');

echo $this->element('left_column',array(
	'primary_column' => $primary_column,
	'secondary_column' => $secondary_column
));

$assignment_types = array(
	'quiz' => 'Quiz',
	'chat' => 'Chat participation',
	'forum' => 'Forum participation',
	'notebook' => 'Notebook submission',
	'other' => 'Other'
);
?>
<div class="gclms-center-column">
	<div class="gclms-content">
		<h1><?= $this->data['Assignment']['title'] ?></h1>    
		<p><?= sprintf(__('Point value: %s',true),$this->data['Assignment']['points']) ?></p>
		
		<p><?= sprintf(__('Type: %s',true),$assignment_types[$this->data['Assignment']['type']]) ?></p>
		
		<?= $this->data['Assignment']['description'] ?>
	</div>
</div>

<?= $this->element('right_column',array(
	'primary_column' => $primary_column,
	'secondary_column' => $secondary_column
));?>