<?
$html->css('glossary', null, null, false);

//These js files shouldn't be loaded if in framed view
$javascript->link(array(
	'vendors/prototype1.6.0.2',
	'prototype_extensions1.0',
	'gclms',
	'glossary'
), false);

echo $this->element('left_column'); ?>
<div class="gclms-center-column">
	<div class="gclms-content">
		<?= $this->element('notifications'); ?>
		<? if(!$framed): ?>
			<h1><? __('Glossary') ?></h1>
			<button href="glossary/add"><? __('Add') ?></button>
			</div>
		<? endif; ?>
		<ul class="glossary">
			<? foreach($this->data as $term): ?>
				<li>
					<a href="glossary/view/<?= $term['GlossaryTerm']['id'] ?>"><?= $term['GlossaryTerm']['term'] ?></a>
				</li>
			<? endforeach; ?>
		</ul>
	</div>
</div>

<?= $this->element('right_column'); ?>