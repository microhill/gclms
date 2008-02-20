<div class="dictionary">
	<? foreach($dictionary_terms as $dictionary_term): ?>
		<h2>
			<a name="<?= Inflector::variable($dictionary_term['DictionaryTerm']['term']) ?>" /><?= $dictionary_term['DictionaryTerm']['term'] ?>
		</h2>
		<div class="description">
			<?= $dictionary_term['DictionaryTerm']['description'] ?>
		</div>
	<? endforeach; ?>
</div>