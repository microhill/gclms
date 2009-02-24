<?
$javascript->link(array(
	'vendors/prototype1.6.0.3',
	'vendors/prototype_extensions1.0',
	'gclms',
	'generate_odt'
), false);

?>
<div class="gclms-content">
	<h1><? __('Generating ODT') ?></h1>
	<?
	$progress = $openDocument->export(array(
		'nodes' => $this->data['nodes'],
		'node_count' => $this->data['node_count'],
		'glossary_terms' => $this->data['glossary_terms'],
		'articles' => $this->data['articles'],
		'group' => $group,
		'course' => $course,
		'stage' => $this->data['stage'],
		'text_direction' => $text_direction,
		'bucket' => $bucket
	));
	
	$progressPercentage = ($progress['stage'] + 1) / ($progress['totalStages'] + 1);
	
	if($progress['stage'] < $progress['totalStages'])
		$nextHref = $groupAndCoursePath . '/export/generate_odt/' . ($progress['stage'] + 1);
	else
		$nextHref = $groupAndCoursePath . '/export';
	?>
	<div style="width: 200px; height: 30px;background-color: red;">
		<div style="height: 30px; width: <?= round(200 * $progressPercentage) ?>px;background-image: url(/img/progress-bar-background.png);">
			
		</div>
	</div>
	<div id="gclms-progress" gclms:next-href="<?= $nextHref ?>">
		<?= round(100 * $progressPercentage) ?>% 
	</div>
</div>