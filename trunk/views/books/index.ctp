<?
$html->css('books', null, null, false);

$javascript->link(array(
	'vendors/prototype1.6.0.3',
	'vendors/prototype_extensions1.0',
	'gclms',
	'vendors/uuid1.0',
	'edit_books'
), false);

echo $this->element('left_column'); ?>

<div class="gclms-center-column">
	<div class="gclms-content gclms-articles">	
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
				if(!$framed) :?>
					<table>
						<tr>
							<td>
								<button class="gclms-add" gclms:prompt-text="Enter the new name of the chapter:"><? __('Add Chapter') ?></button>
							</td>
							<td>
								<button class="gclms-rename" gclms:prompt-text="Enter the new name of the book:"><? __('Rename Book') ?></button>
							</td>
							<td>
								<button class="gclms-delete" gclms:confirm-text="Are you sure you want to delete this book?"><? __('Delete Book') ?></button>
							</td>
						</tr>
					</table>
				<? endif;
				echo '<ul>';
				foreach($book['Chapter'] as $chapter) {
					echo '<li><a href="/' . Group::get('web_path') . '/' . $course['web_path'] . '/chapters/view/' . $chapter['id'] . '">' . $chapter['title'] . '</a></li>';
				}
				echo '</ul>';
				echo '</div>';
			}
			?>
		</div>
	</div>
</div>

<?= $this->element('right_column'); ?>