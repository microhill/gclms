<?
$html->css('glossary', null, null, false);

//These js files shouldn't be loaded if in framed view
$javascript->link(array(
	'vendors/prototype',
	'prototype_extensions',
	'gclms',
	'glossary'
), false);

echo $this->renderElement('left_column'); ?>
<div class="gclms-center-column">
	<div class="gclms-content">
		<?= $this->renderElement('notifications'); ?>
		<h1><? __('Glossary') ?></h1>
		<div id="gclms-menubars">
			<? echo $this->renderElement('menubar',array('buttons' => array(
				array(
					'id' => 'addGlossaryTerm',
					'class' => 'gclms-add',
					'label' => '<u>A</u>dd Term',
					'accesskey' => 'a'
				)
			)));
			?>
		</div>
		<? foreach($this->data as $glossary_term): ?>
			<h2>
				<a name="<?= Inflector::camelize($glossary_term['GlossaryTerm']['term']) ?>" /><?= $glossary_term['GlossaryTerm']['term'] ?>
				<a class="gclms-edit" href="<?= $groupAndCoursePath ?>/glossary/edit/<?= $glossary_term['GlossaryTerm']['id'] ?>"><? __('Edit') ?></a>
			</h2>
			<div class="description">
				<?= $glossary_term['GlossaryTerm']['description'] ?>
			</div>
		<? endforeach; ?>
	</div>
</div>

<?= $this->renderElement('right_column'); ?>