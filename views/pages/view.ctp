<?
$html->css('page', null, null, false);
$html->css($groupAndCoursePath . '/files/css/' . date('Y-m-d'), null, null, false);
//$html->css($groupAndCoursePath . '/files/css', null, null, false);

//If there are any essay questions
if(in_array('5',Set::extract($node['Question'],'{n}.type'))) {
	$javascript->link(array(
		'vendors/tinymce3.2.1.1/tiny_mce'
	), false);
}

$javascript->link(array(
	'vendors/prototype1.6.0.3',
	'vendors/prototype_extensions1.0',
	'vendors/scriptaculous1.8.1/effects',
	'vendors/scriptaculous1.8.1/dragdrop',
	'vendors/swfobject2.1/swfobject',
	'gclms',
	'page',
	'page_selfcheck'
), false);

?>

<div class="gclms-content">
	<div>
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
			<a class="gclms-edit-page gclms-no-frames" href="<?= $groupAndCoursePath ?>/pages/edit/<?= $node['Node']['id'] ?>" target="_top"><? __('Edit') ?></a>
			<? if($framed): ?>
				<a class="gclms-view-with-frames gclms-no-frames" href="<?= $groupAndCoursePath ?>/pages/view/<?= $node['Node']['id'] ?>" target="_top"><? __('View without frames') ?></a>						
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
				if($course['open'])
					$nodeItem['content'] = $mediaFiles->transform_to_s3_links($nodeItem['content'],$course['id']);
				//$nodeItem['content'] = $notebook->linkify($nodeItem['content'],$classUri);
				$nodeItem['content'] = $glossary->linkify($nodeItem['content'],$groupAndCoursePath . '/glossary/view/',$glossary_terms);
				echo $nodeItem['content'];
			} else
				echo $this->element('../pages/page_question',array('question' => $nodeItem));
		}
	
		if(0 && $node['Node']['grade_recorded']): ?>
			<p id="gradeResults"><button id="gradeQuestions"><? __('Grade') ?></button></p>
		<? endif;
		
		if(!empty($virtual_class))
			$sectionUriComponent = '/section:' . $virtual_class['id'];
		else
			$sectionUriComponent = '';
		?>
		<?
		foreach($assignments as $assignment) {
			echo $this->element('../pages/assignment_reminder',array('assignment' => $assignment));
		}
		?>
		
		<div id="gclms-page-navigation">
			<?
			$previousImage = $text_direction == 'rtl' ? 'next' : 'previous';
			$nextImage = $text_direction == 'rtl' ? 'previous' : 'next';
			?>
			<? if(!empty($node['Node']['previous_page_id'])): ?>
				<a class="gclms-back" rel="Prev" accesskey="B" href="../../pages/view/<?= $node['Node']['previous_page_id'] ?>">
					<img src="/img/icons/oxygen_refit/32x32/actions/go-<?= $previousImage ?>-blue.png" alt="<? __('Previous page') ?>" />
				</a>
			<? endif; ?>
		
			<? if(!empty($node['Node']['next_page_id'])): ?>
				<a class="gclms-next" rel="Next" accesskey="N" href="../../pages/view/<?= $node['Node']['next_page_id'] ?>">
					<img src="/img/icons/oxygen_refit/32x32/actions/go-<?= $nextImage ?>-blue.png" alt="<? __('Next page') ?>" />
				</a>
			<? endif; ?>
		</div>
	</div>
	
	<? 	if(!empty($node['Node']['audio_file'])): ?>
	<script type="text/javascript" src="/js/vendors/soundmanager/soundmanager2-jsmin.js"></script>
	<? endif; ?>
</div>