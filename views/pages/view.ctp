<?
$html->css('page', null, null, false);
$html->css('/' . $group['web_path'] . '/files/css', null, null, false);
//$html->css($groupAndCoursePath . '/files/css', null, null, false);

$javascript->link(array(
	'vendors/prototype',
	'prototype_extensions',
	'gclms',
	'vendors/scriptaculous1.8.1/scriptaculous',
	'vendors/scriptaculous1.8.1/dragdrop',
	'page'
), false);

echo $this->renderElement('no_column_background');
?>

<div class="gclms-content">
	<div class="page gclms-noframes">
		<?	
		if(!empty($node['Node']['audio_file'])) {
			$node['Node']['audio_file'] = $groupAndCoursePath  . 'files/' . $node['Node']['audio_file'];
		?>
			<div class="gclms-mp3-player" mp3player:autoplay="true" mp3player:file="<?= $node['Node']['audio_file'] ?>"></div>
		<?
		}
		?>
	
		<div class="gclms-option-buttons">
			<a class="gclms-edit-page" href="<?= $groupAndCoursePath ?>/pages/edit/<?= $node['Node']['id'] ?>">Edit</a>
			<a class="gclms-view-with-frames" href="<?= $groupAndCoursePath ?>/classroom/page/<?= $node['Node']['id'] ?>">View with frames</a>
		</div>
		
		<h1><?= $node['Node']['title'] ?></h1>
		<?
		if(!empty($facilitated_class))
			$classUri = $groupAndCoursePath . 'notebook/' . '/section:' . $facilitated_class['id'];
		else
			$classUri = null;
	
		$nodeItems = array();
		foreach($node['Textarea'] as $textarea) {
			$nodeItems[$textarea['order']] = $textarea;
		}
	
		foreach($node['Question'] as $question) {
			$nodeItems[$question['order']] = $question;
		}
	
		ksort($nodeItems);
	
		foreach($nodeItems as $nodeItem) {
			if(isset($nodeItem['content'])) {
				$nodeItem['content'] = $scripturizer->linkify($nodeItem['content']);
				$nodeItem['content'] = $notebook->linkify($nodeItem['content'],$classUri);
				$nodeItem['content'] = $dictionary->linkify($nodeItem['content'],$groupAndCoursePath . '/dictionary',$dictionary_terms);
				echo $nodeItem['content'];
			} else
				echo $this->renderElement('page_question',array('question' => $nodeItem));
		}
	
		if(0 && $node['Node']['grade_recorded']): ?>
			<p id="gradeResults"><button id="gradeQuestions"><? __('Grade') ?></button></p>
		<? endif;
		
		if(!empty($facilitated_class))
			$sectionUriComponent = '/section:' . $facilitated_class['id'];
		else
			$sectionUriComponent = '';
		?>
		<div id="gclms-page-navigation">
			<? if(!empty($node['Node']['previous_page_id'])): ?>
				<a class="gclms-back" href="<?= $groupAndCoursePath ?>/pages/view/<?= $node['Node']['previous_page_id'] ?>">
					<img src="/img/icons/oxygen_refit/32x32/actions/go-previous-blue.png" alt="<? __('Previous page') ?>" />
				</a>
			<? endif; ?>
		
			<? if(!empty($node['Node']['next_page_id'])): ?>
				<a class="gclms-next" href="<?= $groupAndCoursePath ?>/pages/view/<?= $node['Node']['next_page_id'] ?>">
					<img src="/img/icons/oxygen_refit/32x32/actions/go-next-blue.png" alt="<? __('Next page') ?>" />
				</a>
			<? endif; ?>
		</div>
	</div>
	
	<? 	if(!empty($node['Node']['audio_file'])): ?>
	<script type="text/javascript" src="/js/vendors/soundmanager/soundmanager2-jsmin.js"></script>
	<? endif; ?>
</div>