<?
$html->css(am($css_for_layout,__('TEXT DIRECTION',true)), null, null, false);
$html->css('tags', null, null, false);
$html->css('main', null, null, false);
$html->css('layout', null, null, false);
$html->css('recordset', null, null, false);
$html->css('tooltip', null, null, false);
$html->css('menu', null, null, false);
$html->css('page', null, null, false);
$html->css('panel', null, null, false);

echo $this->renderElement('no_column_background');
?>

<div class="gclms-content">
	<div class="page gclms-noframes">
		<?	
		if(!empty($node['Node']['audio_file'])) {
			$node['Node']['audio_file'] = $groupAndCoursePath  . 'files/' . $node['Node']['audio_file'];
		?>
			<div class="mp3player" mp3player:autoplay="true" mp3player:file="<?= $node['Node']['audio_file'] ?>"></div>
		<?
		}
		?>
	
		<div class="gclms-frames-button"><a href="<?= $groupAndCoursePath ?>/classroom/page/<?= $node['Node']['id'] ?>">View with frames</a></div>
		
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
				$nodeItem['content'] = $dictionary->linkify($nodeItem['content'],$groupAndCoursePath . '/dictionary/panel',$dictionary_terms);
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

