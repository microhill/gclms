<?= $this->renderElement('no_column_background'); ?>
<div id="links">
	<div id="textbooks" class="x-hide-display">
		<?
		foreach($textbooks as $book) {
			echo '<h3>' . $book['Textbook']['title'] . '</h3>';
			echo '<ul>';
			foreach($book['Chapter'] as $chapter) {
				echo '<li><a href="' . $groupAndCoursePath . '/chapters/view/' . $chapter['id'] . '" onclick="return mySubmit(this)">' . $chapter['title'] . '</a></li>';
			}
			echo '</ul>';

		}
		?>
	</div>

	<div id="lessons" class="x-hide-display">
	</div>

	<div id="articles" class="x-hide-display">
		<ul>
		<?
		foreach($articles as $article) {
			echo '<li><a href="/' . $group['web_path'] . '/' . $course['web_path'] . '/articles/view/' . $article['Article']['id'] . '" onclick="return mySubmit(this)">' . $article['Article']['title'] . '</a></li>';
		}
		?>
		</ul
	</div>

	<div id="dictionary" class="x-hide-display">
		<ul>
		<?
		foreach($terms as $dictionary_term) {
			echo '<li><a href="/' . $group['web_path'] . '/' . $course['web_path'] . '/dictionary/show#' . Inflector::variable($dictionary_term['DictionaryTerm']['term'])
					. '" onclick="return mySubmit(this)">' . $dictionary_term['DictionaryTerm']['term'] . '</a></li>';
		}
		?>
		</ul>
	</div>
</div>
<script>
function mySubmit(obj) {
	//call this function only after page has loaded
	//otherwise tinyMCEPopup.close will close the
	//"Insert/Edit Image" or "Insert/Edit Link" window instead

	var win = tinyMCEPopup.getWindowArg("window");

	// insert information now
	win.document.getElementById(tinyMCE.getWindowArg("input")).value = obj.getAttribute('href');

	// close popup window
	tinyMCEPopup.close();
	return false;
}
</script>