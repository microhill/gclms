<? if(isset($translatedPhrases)): ?>
<script>
<? foreach($translatedPhrases->getAll() as $phrase => $translation): ?>
GCLMS.translated_phrases['<?= $phrase ?>'] = '<?= $translation ?>';
<? endforeach; ?>
</script>
<? endif; ?>