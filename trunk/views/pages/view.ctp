<?
$html->css('page', null, null, false);
$html->css($groupAndCoursePath . '/files/css/' . date('Y-m-d'), null, null, false);
//$html->css($groupAndCoursePath . '/files/css', null, null, false);

$javascript->link(array(
	'vendors/prototype',
	'prototype_extensions',
	'gclms',
	'vendors/scriptaculous1.8.1/scriptaculous',
	'vendors/scriptaculous1.8.1/dragdrop',
	'page'
), false);

echo $this->element('no_column_background');
?>

<div class="gclms-content">
	<div class="gclms-page gclms-noframes">
		<?	
		if(!empty($node['Node']['audio_file'])) {
			$node['Node']['audio_file'] = $groupAndCoursePath  . 'files/' . $node['Node']['audio_file'];
		?>
			<div class="gclms-mp3-player" mp3player:autoplay="true" mp3player:file="<?= $node['Node']['audio_file'] ?>"></div>
		<?
		}
		?>
	
		<? if(!$offline): ?>
		<div class="gclms-option-buttons">
			<a class="gclms-edit-page" href="<?= $groupAndCoursePath ?>/pages/edit/<?= $node['Node']['id'] ?>"><? __('Edit') ?></a>
			<? if($framed): ?>
				<a class="gclms-view-with-frames" href="<?= $groupAndCoursePath ?>/pages/view/<?= $node['Node']['id'] ?>" target="_top"><? __('View without frames') ?></a>						
			<? else: ?>
				<a class="gclms-view-with-frames" href="<?= $groupAndCoursePath ?>/classroom/framed#<?= $node['Node']['id'] ?>"><? __('View with frames') ?></a>			
			<? endif ?>

		</div>
		<? endif; ?>
		
		<h1><?= $node['Node']['title'] ?></h1>
		<?
		if(!empty($virtual_class))
			$classUri = $groupAndCoursePath . 'notebook/' . '/section:' . $virtual_class['id'];
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
				//$nodeItem['content'] = $notebook->linkify($nodeItem['content'],$classUri);
				$nodeItem['content'] = $glossary->linkify($nodeItem['content'],$groupAndCoursePath . '/glossary/view/',$glossary_terms);
				echo $nodeItem['content'];
			} else
				echo $this->element('page_question',array('question' => $nodeItem));
		}
	
		if(0 && $node['Node']['grade_recorded']): ?>
			<p id="gradeResults"><button id="gradeQuestions"><? __('Grade') ?></button></p>
		<? endif;
		
		if(!empty($virtual_class))
			$sectionUriComponent = '/section:' . $virtual_class['id'];
		else
			$sectionUriComponent = '';
		?>
		<div id="gclms-page-navigation">
			<?
			$previousImage = $text_direction == 'rtl' ? 'next' : 'previous';
			$nextImage = $text_direction == 'rtl' ? 'previous' : 'next';
			?>
			<? if(!empty($node['Node']['previous_page_id'])): ?>
				<a class="gclms-back" href="<?= $node['Node']['previous_page_id'] ?>">
					<img src="/img/icons/oxygen_refit/32x32/actions/go-<?= $previousImage ?>-blue.png" alt="<? __('Previous page') ?>" />
				</a>
			<? endif; ?>
		
			<? if(!empty($node['Node']['next_page_id'])): ?>
				<a class="gclms-next" href="<?= $node['Node']['next_page_id'] ?>">
					<img src="/img/icons/oxygen_refit/32x32/actions/go-<?= $nextImage ?>-blue.png" alt="<? __('Next page') ?>" />
				</a>
			<? endif; ?>
		</div>
	</div>
	
	<? 	if(!empty($node['Node']['audio_file'])): ?>
	<script type="text/javascript" src="/js/vendors/soundmanager/soundmanager2-jsmin.js"></script>
	<? endif; ?>
</div>