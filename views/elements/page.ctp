<div class="page">
	<?	
	if(!empty($page['Page']['audio_file'])) {
		$page['Page']['audio_file'] = $groupAndCoursePath  . 'files/' . $page['Page']['audio_file'];
	?>
		<div class="mp3player" mp3player:autoplay="true" mp3player:file="<?= $page['Page']['audio_file'] ?>"></div>
	<?
	}
	?>

	<h1><?= $page['Page']['title'] ?></h1>
	<?
	if(!empty($facilitated_class))
		$classUri = $groupAndCoursePath . 'notebook/' . '/section:' . $facilitated_class['id'];
	else
		$classUri = null;

	$pageItems = array();
	foreach($page['Textarea'] as $textarea) {
		$pageItems[$textarea['order']] = $textarea;
	}

	foreach($page['Question'] as $question) {
		$pageItems[$question['order']] = $question;
	}

	ksort($pageItems);

	foreach($pageItems as $pageItem) {
		if(isset($pageItem['content'])) {
			$pageItem['content'] = $scripturizer->linkify($pageItem['content']);
			$pageItem['content'] = $notebook->linkify($pageItem['content'],$classUri);
			$pageItem['content'] = $dictionary->linkify($pageItem['content'],$groupAndCoursePath . '/dictionary/panel',$dictionary_terms);
			echo $pageItem['content'];
		} else
			echo $this->renderElement('page_question',array('question' => $pageItem));
	}

	if(0 && $page['Page']['grade_recorded']): ?>
		<p id="gradeResults"><button id="gradeQuestions"><? __('Grade') ?></button></p>
	<? endif;

	?>
	<?= $this->renderElement('page_navigation'); ?>
</div>

<? 	if(!empty($page['Page']['audio_file'])): ?>
<script type="text/javascript" src="/js/vendors/soundmanager/soundmanager2-jsmin.js"></script>
<? endif; ?>