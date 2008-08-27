<? if(isset($translatedPhrases)): ?>
<script>
<? foreach($translatedPhrases->getAll() as $phrase => $translation): ?>
gclms.translated_phrases['<?= $phrase ?>'] = '<?= $translation ?>';
<? endforeach; ?>
</script>
<? endif; ?>