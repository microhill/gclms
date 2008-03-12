<?
$javascript->link(array(
	'vendors/prototype',
	'prototype_extensions',
	'vendors/tinymce3.0.4/tiny_mce_popup',
	'tinymce_popup',
	'course'
), false);

echo $this->renderElement('no_column_background'); ?>

<div class="gclms-content gclms-links">
	<h2>Pages</h2>
	<?
	echo $this->renderElement('nodes_tree',array(
		'nodes' => $nodes
	));
	?>
	
	<? if(!empty($book)): ?>	
	<h2>Books</h2>	
	<div id="books">
		<?
		foreach($books as $book) {
			echo '<h3>' . $book['Book']['title'] . '</h3>';
			echo '<ul>';
			foreach($book['Chapter'] as $chapter) {
				echo '<li><a href="' . $groupAndCoursePath . '/chapters/view/' . $chapter['id'] . '">' . $chapter['title'] . '</a></li>';
			}
			echo '</ul>';

		}
		?>
	</div>
	<? endif; ?>

	<? if(!empty($articles)): ?>
		<h2>Articles</h2>
		<div id="articles">
			<ul>
			<?
			foreach($articles as $article) {
				echo '<li><a href="/' . $group['web_path'] . '/' . $course['web_path'] . '/articles/view/' . $article['Article']['id'] . '">' . $article['Article']['title'] . '</a></li>';
			}
			?>
			</ul>
		</div>
	<? endif; ?>
	
	<? if(!empty($terms)): ?>
	<h2>Dictionary Terms</h2>
	<div id="dictionary">
		<ul>
		<?
		foreach($terms as $dictionary_term) {
			echo '<li><a href="/' . $group['web_path'] . '/' . $course['web_path'] . '/dictionary/show#' . Inflector::variable($dictionary_term['DictionaryTerm']['term'])
					. '">' . $dictionary_term['DictionaryTerm']['term'] . '</a></li>';
		}
		?>
		</ul>
	</div>
	<? endif; ?>
</div>