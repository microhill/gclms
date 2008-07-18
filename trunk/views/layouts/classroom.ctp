<?=$html->docType('xhtml-strict'); ?>
<html xmlns="http://www.w3.org/1999/xhtml" lang="<?= Configure::read('Config.language') ?>" dir="<? echo $text_direction; ?>">
<head>
<title><?= $course['title'] ?> - <?= $group['name'] ?></title>
	<link rel="stylesheet" type="text/css" href="/js/vendors/ext-2.0/resources/css/ext-all.css" />
	<link rel="stylesheet" type="text/css" href="/js/vendors/ext-2.0/resources/css/xtheme-gray.css" />

    <? // $html->css(am($css_for_layout,$text_direction))
    ?>
	<?
	$html->css('tags', null, null, false);
	
	$html->css('main', null, null, false);
	$html->css('classroom', null, null, false);

	echo $asset->css_for_layout();

	//$cssLastUpdated = empty($group['css_updated']) ? '' : '/' . $group['css_updated'] . '.css';
	?>
</head>
<body class="classroom"
	gclms:group="<?= @$group['web_path'] ?>"
	gclms:course="<?= @$course['web_path'] ?>"
	lms:facilitated_class="<?= @$facilitated_class['id'] ?>"
	gclms:controller="<?= $this->name ?>"
	gclms:action="<?= $this->action ?>">

	<?= $this->element('no_column_background'); ?>
	
	<div id="header">
		<?= $this->element('../classroom/header') ?>
	</div>

	<div class="x-hide-display">		
		<div id="navigationViewportContent" class="gclms-viewport-content">
			<? //$this->element('lesson_navigation') ?>
			<?
			//pr($announcments);
			
			if(!empty($nodes))
				echo $this->element('nodes_tree',array(
					'nodes' => $nodes,
					'here' => $this->here,
					'sibling_links' => false
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
			<iframe id="notebookViewportContent" src="#" class="gclms-viewport-content" style="border: 0px none; frameBorder: 0; width: 100%; height: 100%;"></iframe>
		<? endif?>

		<? if(@$facilitated_class): ?>
			<iframe id="chatViewportContent" src="#" class="gclms-viewport-content" style="border: 0px none; frameBorder: 0; width: 100%; height: 100%;"></iframe>
			<iframe id="discussionViewportContent" src="#" class="gclms-viewport-content" style="border: 0px none; frameBorder: 0; width: 100%; height: 100%;"></iframe>
		<? endif; ?>
	</div>
	
	<?= $asset->js_for_layout(); ?>

	<script type="text/javascript">
	Ext.BLANK_IMAGE_URL = '/img/blank-1.png';
	
    Ext.onReady(function(){
        Ext.state.Manager.setProvider(new Ext.state.CookieProvider());

		sidebarItems = [{
	        contentEl: 'navigationViewportContent',
	        id: 'navigationViewport',
	        title: 'Lesson Navigation',
	        border:false,
	        autoScroll:true,
	        iconCls:'navigation'
     	}];
     	
     	sidebarItems.push({
            title:'Bible',
            id: 'bibleViewport',
            contentEl: 'bibleViewportContent',
            border:false,
            autoScroll: false,
            iconCls:'bible',
            listeners: {beforeexpand: GCLMS.Triggers.get('#bibleViewport:expand')}
         });
         
         if($('booksViewportContent'))
	         sidebarItems.push({
	            title:'Books',
	            id: 'booksViewport',
	            contentEl: 'booksViewportContent',
	            border:false,
	            autoScroll:false,
	            iconCls:'books',
	            listeners: {beforeexpand: GCLMS.Triggers.get('#booksViewport:expand')}
			});
			
         if($('articlesViewportContent'))
	         sidebarItems.push({
	            title:'Articles',
	            id: 'articlesViewport',
	            contentEl: 'articlesViewportContent',
	            border:false,
	            autoScroll: false,
	            iconCls:'articles',
	            listeners: {beforeexpand: GCLMS.Triggers.get('#articlesViewport:expand')}
			});
			
         if($('glossaryViewportContent'))
	         sidebarItems.push({
	            title:'Glossary',
	            id: 'glossaryViewport',
	            contentEl: 'glossaryViewportContent',
	            border:false,
	            autoScroll: false,
	            iconCls:'glossary',
	            listeners: {beforeexpand: GCLMS.Triggers.get('#glossaryViewport:expand')}
			});

		var viewport = new Ext.Viewport({
            layout:'border',
            items:[
                new Ext.BoxComponent({ // raw
                    region:'north',
                    el: 'header',
                    height:32
                }),{
                    region:'west',
                    id:'sidebarPanel',
                    title:'Sidebar',
                    split:true,
                    width: 325,
                    minSize: 275,
                    maxSize: 600,
                    collapsible: false,
                    margins:'0 0 0 5',
                    layout:'accordion',
                    items: sidebarItems
                },
                new Ext.TabPanel({
                    region:'center',
                    id: 'classroomTabs',
                    deferredRender:false,
                    activeTab:0,
                    items:[{
                        title: 'Lesson',
			            contentEl: 'lessonViewportContent',
			            border:false,
			            autoScroll: false,
                        id: 'lessonTab'
                        //listeners: {activate: GCLMS.Triggers.get('#lessonTab:activate')}
                    }
                    
					<? if(@$facilitated_class): ?>
                    ,{
                        id: 'chatTab',
                        title: 'Chat',
                        autoScroll:true,
                        listeners: {activate: GCLMS.Triggers.get('#chatTab:activate')}
                    },{
						id: 'discussionTab',
                        title: 'Discussion',
                        contentEl: 'discussionViewportContent',
                        autoScroll: false,
                        border:false,
                        listeners: {activate: GCLMS.Triggers.get('#discussionTab:activate')}
                    }
                    <? endif; ?>   
                      
					<? if(!empty($user)): ?>
                    ,{
						id: 'notebookTab',
                        title: 'Notebook',
                        contentEl: 'notebookViewportContent',
                        autoScroll:true,
                        listeners: {activate: GCLMS.Triggers.get('#notebookTab:activate')}
                    }                    
                    <? endif; ?>                   
				]
                })
             ]
        });
    });
    
    function test() {
     alert('test'); //GCLMS.Triggers.get('#discussionTab:activate')
    }
	</script>
</body>
</html>