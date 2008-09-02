<?
$html->css('notebook', null, null, false);

$javascript->link(array(
	'vendors/prototype',
	'prototype_extensions',
	'gclms',
	'vendors/uuid',
	'notebook'
), false);

echo $this->element('left_column'); ?>
		
<div class="gclms-center-column">
	<div class="gclms-content">		
		
		<h1><?= __('Notebook') ?></h1>

		<? if(!empty($archive)): ?>
			<div id="gclms-notebook-archive">
				<h2><? __('Archive') ?></h2>
				<ul>
					<? foreach($archive as $entry): ?>
						<li class="gclms-notebook-entry" id="<?= $entry['NotebookEntry']['id'] ?>">
							<a href="/notebook/view/<?= $entry['NotebookEntry']['id'] ?>" title="Last modified: <?= $myTime->niceShortDate($entry['NotebookEntry']['modified']) ?>"><?= $entry['NotebookEntry']['title'];?></a>
						</li>
					<? endforeach; ?>
				</ul>
			</div>
		<? endif; ?>
		<?= $this->element('buttons',array('buttons' => array(
			array(
				'text' => __('Add Entry',true),
				'href' => '/notebook/add'
			)
		)));
		?>
		
		<? if(!empty($entries)): ?>
			<div class="gclms-notebook-entries">
				<? foreach($entries as $entry): ?>
					<div class="gclms-notebook-entry">
						<h2><a href="<?= $groupAndCoursePath ?>/notebook/view/<?= $entry['NotebookEntry']['id'] ?>"><?= $entry['NotebookEntry']['title'];?></a></h2>
						<p class="gclms-notebook-entry-modified"><?= $myTime->niceShortDate($entry['NotebookEntry']['modified']) ?></p>
						<?= $entry['NotebookEntry']['content'] ?>
					</div>
				<? endforeach; ?>
			</div>
		<? endif; ?>
		
	</div>
</div><?= $this->element('right_column'); ?>