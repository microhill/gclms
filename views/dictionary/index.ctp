<?
$html->css('dictionary', null, null, false);

//These js files shouldn't be loaded if in framed view
$javascript->link(array(
	'vendors/prototype',
	'prototype_extensions',
	'gclms',
	'dictionary'
), false);

echo $this->renderElement('left_column'); ?>
<div class="gclms-center-column">
	<div class="gclms-content">
		<?= $this->renderElement('notifications'); ?>
		<h1><? __('Dictionary') ?></h1>
		<div id="gclms-menubars">
			<? echo $this->renderElement('menubar',array('buttons' => array(
				array(
					'id' => 'addDictionaryTerm',
					'class' => 'add',
					'label' => '<u>A</u>dd Term',
					'accesskey' => 'a'
				)
			)));
			?>
		</div>
		<? foreach($this->data as $dictionary_term): ?>
			<h2>
				<a name="<?= Inflector::camelize($dictionary_term['DictionaryTerm']['term']) ?>" /><?= $dictionary_term['DictionaryTerm']['term'] ?>
				<a class="gclms-edit" href="<?= $groupAndCoursePath ?>/dictionary/edit/<?= $dictionary_term['DictionaryTerm']['id'] ?>"><? __('Edit') ?></a>
			</h2>
			<div class="description">
				<?= $dictionary_term['DictionaryTerm']['description'] ?>
			</div>
		<? endforeach; ?>
	</div>
</div>

<?= $this->renderElement('right_column'); ?>