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
			<button href="books/add"><? __('Add') ?></button>
		<? endif; ?>

		<div id="gclms-books">
			<?
			foreach($books as $book) {
				echo '<div class="gclms-book" gclms:id="' . $book['Book']['id'] . '">';
				echo '<h2>' . $book['Book']['title'] . '</h2>';
				if(!$framed)
					echo $this->element('buttons',array('buttons' => array(
						array(
							'class' => 'gclms-add',
							'text' => __('Add Chapter',true),
							'strings' => array(
								'gclms:prompt-text' => __('Enter the new name of the chapter:',true)
							)
						),
						array(
							'class' => 'gclms-rename',
							'text' => __('Rename Book',true),
							'strings' => array(
								'gclms:prompt-text' => __('Enter the new name of the book:',true)
							)
						),
						array(
							'class' => 'gclms-delete',
							'text' => __('Delete Book',true),
							'strings' => array(
								'gclms:confirm-text' => __('Are you sure you want to delete this book?',true)
							)
						)
					)));
				echo '<ul>';
				foreach($book['Chapter'] as $chapter) {
					echo '<li><a href="/' . $group['web_path'] . '/' . $course['web_path'] . '/chapters/view/' . $chapter['id'] . '">' . $chapter['title'] . '</a></li>';
				}
				echo '</ul>';
				echo '</div>';
			}
			?>
		</div>
	</div>
</div>

<?= $this->element('right_column'); ?>