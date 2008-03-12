<?
$html->css('textbooks', null, null, false);

$javascript->link(array(
	'vendors/prototype',
	'prototype_extensions',
	'gclms',
	'vendors/uuid',
	'edit_textbooks'
), false);

echo $this->renderElement('left_column'); ?>

<div class="gclms-center-column">
	<div class="gclms-content">
		<div id="gclms-spinner"><img src="/img/permanent/spinner2007-09-14.gif"/></div>
		<h1><? __('Textbooks') ?></h1>
		<p class="buttons">
			<button id="addTextbook" class="add" prompt:text="<? __('Enter the name of the textbook:') ?>"><? __('Add') ?></button>
			<button id="renameTextbook" class="rename" prompt:text="<? __('Enter the new name of the textbook:') ?>"><? __('Rename') ?></button>
			<button id="deleteTextbook" class="delete" confirm:text="<? __('Are you sure you want to delete this textbook?') ?>"><? __('Delete') ?></button>
			<button id="editTextbook" class="edit"><? __('Edit') ?></button>
		</p>
		<?
		echo '<ul id="textbooks" class="textbooks">';
		foreach($textbooks as $textbook) {
			echo '<li id="textbook_' . $textbook['Textbook']['id'] . '" textbook:id="' . $textbook['Textbook']['id'] . '"><a href="#">' . $textbook['Textbook']['title'] . '</a></li>';
		}
		echo '</ul>';
		?>
	</div>
</div>

<?= $this->renderElement('right_column'); ?>