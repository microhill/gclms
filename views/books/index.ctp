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
		<? if(!$framed): ?>
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
		<? endif; ?>

		<div class="books">
			<?
			foreach($books as $book) {
				echo '<h2>' . $book['Book']['title'] . '</h2>';
				echo $this->element('menubar',array('buttons' => array(
					array(
						'id' => 'editBook',
						'class' => 'gclms-edit',
						'label' => __('Edit Book',true)
					)
				)));
				echo '<ul>';
				foreach($book['Chapter'] as $chapter) {
					echo '<li><a href="/' . $group['web_path'] . '/' . $course['web_path'] . '/chapters/view/' . $chapter['id'] . '">' . $chapter['title'] . '</a></li>';
				}
				echo '</ul>';
			}
			?>
		</div>
	</div>
</div>

<?= $this->element('right_column'); ?>