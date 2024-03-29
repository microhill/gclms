<?
$javascript->link(array(
	'vendors/prototype1.6.0.3',
	'vendors/prototype_extensions1.0',
	'vendors/tinymce3.1.0.1/tiny_mce_popup',
	'tinymce_popup',
	'course'
), false);

?>

<div class="gclms-content gclms-links">
	<?
	if(!empty($nodes)) {
		echo '<h2>Pages</h2>';
	 	echo $this->element('nodes_tree',array(
			'nodes' => $nodes,
			'url_prefix' => '../../pages/view/'
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
				echo '<li><a href="../../chapters/view/' . $chapter['id'] . '">' . $chapter['title'] . '</a></li>';
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
				echo '<li><a href="../../articles/view/' . $article['Article']['id'] . '">' . $article['Article']['title'] . '</a></li>';
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
			echo '<li><a href="../../glossary/view/' . Inflector::variable($glossary_term['GlossaryTerm']['id'])
					. '">' . $glossary_term['GlossaryTerm']['term'] . '</a></li>';
		}
		?>
		</ul>
	</div>
	<? endif; ?>
</div>