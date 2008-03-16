<?
$html->css('books', null, null, false);

$javascript->link(array(
	'vendors/prototype',
	'prototype_extensions',
	'gclms',
	'vendors/uuid',
	'edit_books'
), false);

echo $this->renderElement('left_column'); ?>

<div class="gclms-center-column">
	<div class="gclms-content articles">	
		<?= $this->renderElement('notifications'); ?>
		<div id="gclms-spinner"><img src="/img/permanent/spinner2007-09-14.gif"/></div>
		<h1><? __('Books') ?></h1>
		<div id="gclms-menubar">
			<? echo $this->renderElement('menubar',array('buttons' => array(
				array(
					'id' => 'addBook',
					'class' => 'add',
					'label' => '<u>A</u>dd Book',
					'accesskey' => 'a',
					'strings' => array(
						'prompt:text' => 'Enter the name of the book:'
					)
				),
				array(
					'id' => 'renameBook',
					'class' => 'rename',
					'label' => '<u>R</u>ename Book',
					'accesskey' => 'r',
					'strings' => array(
						'prompt:text' => 'Enter the new name of the book:'
					),
					'disabled' => 'disabled'
				),
				array(
					'id' => 'deleteBook',
					'class' => 'delete',
					'label' => '<u>D</u>elete Book',
					'accesskey' => 'd',
					'strings' => array(
						'gclms:confirm-text' => 'Are you sure you want to delete this book?'
					),
					'disabled' => 'disabled'
				),
				array(
					'id' => 'editBook',
					'class' => 'edit',
					'label' => '<u>E</u>dit Book',
					'accesskey' => 'e',
					'strings' => array(
						'gclms:confirm-text' => 'Are you sure you want to delete this book?'
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

<?= $this->renderElement('right_column'); ?>