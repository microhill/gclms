<div class="books">
	<?
	foreach($books as $book) {
		echo '<h2>' . $book['Book']['title'] . '</h2>';
		echo '<ul>';
		foreach($book['Chapter'] as $chapter) {
			echo '<li><a href="/' . Group::get('web_path') . '/' . $course['web_path'] . '/chapters/view/' . $chapter['id'] . '">' . $chapter['title'] . '</a></li>';
		}
		echo '</ul>';
	}
	?>
</div>