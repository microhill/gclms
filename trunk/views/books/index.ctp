<?
$html->css('books', null, null, false);

$javascript->link(array(
	'vendors/prototype',
	'prototype_extensions',
	'gclms',
	'vendors/uuid',
	'edit_books'
), false);

echo $this->element('left_column'); ?>

<div class="gclms-center-column">
	<div class="gclms-content articles">	
		<?= $this->element('notifications'); ?>
		<div id="gclms-spinner"><img src="/img/permanent/spinner2007-09-14.gif" alt="Spinner" /></div>
		<h1><? __('Books') ?></h1>
		<div id="gclms-menubar">
			<? echo $this->element('menubar',array('buttons' => array(
				array(
					'id' => 'addBook',
					'class' => 'gclms-add',
					'label' => __('Add Book',true),
					'accesskey' => 'a',
					'strings' => array(
						'gclms:prompt-text' => __('Enter the name of the book:',true)
					)
				),
				array(
					'id' => 'renameBook',
					'class' => 'gclms-rename',
					'label' => __('Rename Book',true),
					'accesskey' => 'r',
					'strings' => array(
						'gclms:prompt-text' => __('Enter the new name of the book:',true)
					),
					'disabled' => 'disabled'
				),
				array(
					'id' => 'deleteBook',
					'class' => 'gclms-delete',
					'label' => __('Delete Book',true),
					'accesskey' => 'd',
					'strings' => array(
						'gclms:confirm-text' => __('Are you sure you want to delete this book?',true)
					),
					'disabled' => 'disabled'
				),
				array(
					'id' => 'editBook',
					'class' => 'gclms-edit',
					'label' => __('Edit Book',true),
					'accesskey' => 'e',
					'strings' => array(
						'gclms:confirm-text' => __('Are you sure you want to delete this book?',true)
					),
					'disabled' => 'disabled'
				)
			)));
			?>
		</div>
		<ul id="books" class="books">
		<?
		foreach($books as $book) {
			echo '<li id="book_' . $book['Book']['id'] . '" book:id="' . $book['Book']['id'] . '"><a href="#">' . $book['Book']['title'] . '</a></li>';
		}
		?>
		</ul>
	</div>
</div>

<?= $this->element('right_column'); ?>