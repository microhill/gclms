<?
$javascript->link(array(
	'vendors/prototype',
	'prototype_extensions',
	'vendors/tinymce3.0.5/tiny_mce_popup',
	'tinymce_popup',
	'course'
), false);

echo $this->renderElement('no_column_background'); ?>

<div class="gclms-content gclms-links">
	<?
	pr($nodes);
	if(!empty($nodes)) {
		echo '<h2>Pages</h2>';
	 	echo $this->renderElement('nodes_tree',array(
			'nodes' => $nodes
		));
	}
	?>
	
	<? if(!empty($books)): ?>	
	<h2>Books</h2>	
	<div id="books">
		<?
		foreach($books as $book) {
			echo '<h3>' . $book['Book']['title'] . '</h3>';
			echo '<ul>';
			foreach($book['Chapter'] as $chapter) {
				echo '<li><a href="' . $groupAndCoursePath . '/books/chapter/' . $chapter['id'] . '">' . $chapter['title'] . '</a></li>';
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
	<h2>Glossary Terms</h2>
	<div id="glossary">
		<ul>
		<?
		foreach($terms as $glossary_term) {
			echo '<li><a href="/' . $group['web_path'] . '/' . $course['web_path'] . '/glossary/show#' . Inflector::variable($glossary_term['GlossaryTerm']['term'])
					. '">' . $glossary_term['GlossaryTerm']['term'] . '</a></li>';
		}
		?>
		</ul>
	</div>
	<? endif; ?>
</div>