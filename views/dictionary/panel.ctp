<!-- h1><? __('Dictionary') ?></h1 -->
<? foreach($dictionary_terms as $dictionary_term): ?>
	<h2><?= $dictionary_term['DictionaryTerm']['term'] ?></h2>
	<p><?= $dictionary_term['DictionaryTerm']['description'] ?></p>
<? endforeach; ?>