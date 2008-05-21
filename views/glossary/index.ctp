<?
$html->css('glossary', null, null, false);

//These js files shouldn't be loaded if in framed view
$javascript->link(array(
	'vendors/prototype',
	'prototype_extensions',
	'gclms',
	'glossary'
), false);

echo $this->element('left_column'); ?>
<div class="gclms-center-column">
	<div class="gclms-content">
		<?= $this->element('notifications'); ?>
		<h1><? __('Glossary') ?></h1>
		<div id="gclms-menubars">
			<? echo $this->element('menubar',array('buttons' => array(
				array(
					'id' => 'addGlossaryTerm',
					'class' => 'gclms-add',
					'label' => '<u>A</u>dd Term',
					'accesskey' => 'a'
				)
			)));
			?>
		</div>
		<ul class="glossary">
			<? foreach($this->data as $term): ?>
				<li>
					<a href="/<?= $group['web_path'] ?>/<?= $course['web_path'] ?>/glossary/view/<?= $term['GlossaryTerm']['id'] ?>"><?= $term['GlossaryTerm']['term'] ?></a>
				</li>
			<? endforeach; ?>
		</ul>
	</div>
</div>

<?= $this->element('right_column'); ?>