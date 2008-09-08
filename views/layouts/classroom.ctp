<?=$html->docType('xhtml-strict'); ?>
<html xmlns="http://www.w3.org/1999/xhtml" lang="<?= Configure::read('Config.language') ?>" dir="<? echo $text_direction; ?>">
<head>
<title><?= $course['title'] ?> - <?= $group['name'] ?></title>
	<link rel="stylesheet" type="text/css" href="/js/vendors/ext-2.0/resources/css/ext-all.css" />
	<link rel="stylesheet" type="text/css" href="/js/vendors/ext-2.0/resources/css/xtheme-gray.css" />

    <? // $html->css(am($css_for_layout,$text_direction))

	$html->css('ltr', null, null, false);
	$html->css('main', null, null, false);
	$html->css('classroom', null, null, false);

	echo $asset->css_for_layout();

	//$cssLastUpdated = empty($group['css_updated']) ? '' : '/' . $group['css_updated'] . '.css';
	?>
</head>
<body
	gclms-group="<?= @$group['web_path'] ?>"
	gclms-course="<?= @$course['web_path'] ?>"
	gclms:virtual-class="<?= @$class['id'] ?>"
	gclms-controller="<?= $this->name ?>"
	gclms-action="<?= $this->action ?>">

	<?= $this->element('no_column_background'); ?>
	
	<div id="header">
		<?= $this->element('../classroom/header') ?>
	</div>

	<div class="x-hide-display gclms-classroom-viewport">		
		<div id="navigationViewportContent" class="gclms-viewport-content">
			<? //$this->element('lesson_navigation') ?>
			<?
			//pr($announcments);
			if(!empty($nodes))
				echo $this->element('nodes_tree',array(
					'nodes' => $nodes,
					'here' => $this->here,
					'url_prefix' => $groupAndCoursePath . '/pages/view/'
				));
			?>
		</div>
		
		<iframe id="bibleViewportContent" src="#" class="gclms-viewport-content" style="border: 0px none; frameBorder: 0; width: 100%; height: 100%;"></iframe>
		
		<iframe id="lessonViewportContent" name="courseContent" src="#" class="gclms-viewport-content" style="border: 0px none; frameBorder: 0; width: 100%; height: 100%;"></iframe>
		
		<!-- iframe id="lessonViewportContent"
			
			src="<?= $groupAndCoursePath . '/classroom/page/' . 123 ?>" class="gclms-viewport-content" style="border: 0px none; frameBorder: 0; width: 100%; height: 100%;"></iframe -->
			
		<? if(@$book_count): ?>
			<iframe id="booksViewportContent" src="#" class="gclms-viewport-content" style="border: 0px none; frameBorder: 0; width: 100%; height: 100%;"></iframe>
		<? endif; ?>
	
		<? if(@$article_count): ?>
			<iframe id="articlesViewportContent" src="#" class="gclms-viewport-content" style="border: 0px none; frameBorder: 0; width: 100%; height: 100%;"></iframe>
		<? endif; ?>
		
		<? if(@$glossary_term_count): ?>
			<iframe id="glossaryViewportContent" src="#" class="gclms-viewport-content" style="border: 0px none; frameBorder: 0; width: 100%; height: 100%;"></iframe>
		<? endif; ?>

		<? if(!empty($user)): ?>
			<iframe id="forumsViewportContent" src="#" class="gclms-viewport-content" style="border: 0px none; frameBorder: 0; width: 100%; height: 100%;"></iframe>
			<iframe id="notebookViewportContent" src="#" class="gclms-viewport-content" style="border: 0px none; frameBorder: 0; width: 100%; height: 100%;"></iframe>
		<? endif?>

		<? if(@$class): ?>
			<iframe id="chatViewportContent" src="#" class="gclms-viewport-content" style="border: 0px none; frameBorder: 0; width: 100%; height: 100%;"></iframe>
		<? endif; ?>
	</div>
	<?= $asset->js_for_layout(); ?>
</body>
</html>