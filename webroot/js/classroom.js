GCLMS.ClassroomController = {
	loadViewport: function() {
		if(location.href.indexOf('#') != -1) {
			var href = location.href.split('#');
			Ext.get('lessonViewportContent').dom.src = GCLMS.urlPrefix + 'pages/view/' + href[1] + '?framed';
		}
		
		//url = '/' + document.body.getAttribute('gclms:group') + '/' + document.body.getAttribute('gclms:course') + '/' + document.body.getAttribute('gclms:virtual-class')

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
				
			var tabItems = [{
	                title: 'Lesson',
		            contentEl: 'lessonViewportContent',
		            border:false,
		            autoScroll: false,
	                id: 'lessonTab'
	                //listeners: {activate: GCLMS.Triggers.get('#lessonTab:activate')}
	            }];
				
		     if($('notebookViewportContent'))
		         tabItems.push({
					id: 'notebookTab',
	                title: 'Notebook',
	                contentEl: 'notebookViewportContent',
	                autoScroll:true,
	                listeners: {activate: GCLMS.Triggers.get('#notebookTab:activate')}
	            });
				
		     if($('discussionViewportContent'))
		         tabItems.push({
					id: 'discussionTab',
	                title: 'Discussion',
	                contentEl: 'discussionViewportContent',
	                autoScroll: false,
	                //border:false,
	                listeners: {activate: GCLMS.Triggers.get('#discussionTab:activate')}
	            });
				
		     if($('chatViewportContent'))
		         tabItems.push({
	                id: 'chatTab',
	                title: 'Chat',
	                autoScroll:true,
	                listeners: {activate: GCLMS.Triggers.get('#chatTab:activate')}
	            });
		
			var viewport = new Ext.Viewport({
		        layout:'border',
		        items:[
		            new Ext.BoxComponent({
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
		                items: tabItems
		            })
		         ]
		    });
		});	
	},
	
	expandBibleViewport: function() {
		url = '/' + document.body.getAttribute('gclms:group') + '/' + document.body.getAttribute('gclms:course') + '/bible_kjv/books';
		if(!Ext.get('bibleViewportContent').loaded)
			Ext.get('bibleViewportContent').dom.src = url;
		Ext.get('bibleViewportContent').loaded = true;	
	},
	
	expandBooksViewport: function(){
		url = '/' + document.body.getAttribute('gclms:group') + '/' + document.body.getAttribute('gclms:course') + '/books?framed';
		if(!Ext.get('booksViewportContent').loaded)
			Ext.get('booksViewportContent').dom.src = url;
		Ext.get('booksViewportContent').loaded = true;	
	},
	
	expandArticlesViewport: function(){
		url = '/' + document.body.getAttribute('gclms:group') + '/' + document.body.getAttribute('gclms:course') + '/articles?framed';
		if(!Ext.get('articlesViewportContent').loaded)
			Ext.get('articlesViewportContent').dom.src = url;
		Ext.get('articlesViewportContent').loaded = true;
	},
	
	expandGlossaryViewport: function(){
		url = '/' + document.body.getAttribute('gclms:group') + '/' + document.body.getAttribute('gclms:course') + '/glossary?framed';
		if(!Ext.get('glossaryViewportContent').loaded)
			Ext.get('glossaryViewportContent').dom.src = url;
		Ext.get('glossaryViewportContent').loaded = true;
	},
	
	activateChatTab: function() {
		
	},
	
	activateDiscussionTab: function() {
		url = '/' + document.body.getAttribute('gclms:group') + '/' + document.body.getAttribute('gclms:course') + '/' + document.body.getAttribute('gclms:virtual-class') + '/discussion/forums?framed';
		currentSrc = Ext.get('discussionViewportContent').dom.src;
		if(currentSrc.indexOf(url) == -1) {
			Ext.get('discussionViewportContent').dom.src = url;
		}
		
		return true;
	},
	
	activateNotebookTab: function() {
		url = '/' + document.body.getAttribute('gclms:group') + '/' + document.body.getAttribute('gclms:course') + '/' + document.body.getAttribute('gclms:virtual-class') + '/notebook/edit';
		currentSrc = Ext.get('notebookViewportContent').dom.src;
		if(currentSrc.indexOf(url) == -1) {
			Ext.get('notebookViewportContent').dom.src = url;
		}
		
		return true;
	},
	
	gotoViewportLink: function() {
		elm = this.up('.gclms-viewport-content');
		id = elm.id;
		
		if(id == 'navigationViewportContent')
			return false;
	
		event.stop();
		
		href = this.getAttribute('href');
		
		elm.setAttribute('loaded:url',href);
		elm = Ext.get(id);
		elm.load({
			url: href,
			text: '&nbsp;',
			callback: GCLMS.Triggers.get('.gclms-viewport-content')[':updated'].bind(elm)
		});		
	},
	
	highlightCurrentPage: function(url) {
		url = url.split('pages/view/');
		url = url[1].split('?');

		$$('a.gclms-selected').each(function(node){
			node.removeClassName('gclms-selected');
		})

		var a = $$('a[href*="' + url[0] + '"]').first();
		
		a.addClassName('gclms-selected');
		li = a.up('li');
		
		do {
			if(!li.hasClassName('gclms-empty')) {
				li.removeClassName('gclms-collapsed');
				li.addClassName('gclms-expanded');
			}			
		} while (li = li.up('li'));
	},
	
	gotoPageLink: function(event) {
		event.stop();
		Ext.get('lessonViewportContent').dom.src = this.getAttribute('href') + '?framed';
		
		$$('a.gclms-selected').each(function(node){
			node.removeClassName('gclms-selected');
		})
		if(this.addClassName)
			this.addClassName('gclms-selected');
				
		Ext.getCmp('classroomTabs').activate('lessonTab');
		
		return false;
		
		if(this.hasClassName('lesson')) {
			li = this.up('li');
			
			img = li.select('img').first();
			if(img.hasClassName('gclms-expanded')) {
				img.removeClassName('gclms-expanded');
				img.addClassName('gclms-collapsed');
				if(li.select('ul').length) {
					li.select('ul').first().hide();
				}
			} else {
				img.removeClassName('gclms-collapsed');
				img.addClassName('gclms-expanded');
				
				if(!li.select('ul').length) {
					li.insert('<ul><li>Loading...</li></ul>');
					new Ajax.Request(this.getAttribute('href'), {
						li: li,
						onSuccess: function(request) {
							li.select('ul').first().remove();
							li.insert(request.responseText);
							li.observeRules(GCLMS.Triggers.get('.gclms-lesson-navigation'));
						}
					});
				} else {
					li.select('ul').first().displayAsBlock();
				}
			}
			event.stop();
			return false;
		}

	},
	
	gotoArticleLink: function() {
		event.stop();
		
		elm = Ext.get('articlesViewportContent');
		
		href = this.getAttribute('href');
		elm.dom.setAttribute('loaded:url', href);
		
		Ext.getCmp('articlesViewport').expand();
		
		if (GCLMS.cache.get(href)) {
			elm.update(GCLMS.cache.get(href));
			elm.observeRules(GCLMS.Triggers.get('.gclms-viewport-content'));
			return true;
		}
		
		Ext.get('articlesViewportContent').load({
			url: elm.dom.getAttribute('loaded:url'),
			text: '&nbsp;',
			callback: GCLMS.Triggers.get('.gclms-viewport-content')[':updated'].bind(elm)
		});
	},
	
	gotoBookLink: function() {
		event.stop();
		
		elm = Ext.get('booksViewportContent');
		
		href = this.getAttribute('href');
		elm.dom.setAttribute('loaded:url', href);
		
		Ext.getCmp('booksViewport').expand();
		
		if (GCLMS.cache.get(href)) {
			elm.update(GCLMS.cache.get(href));
			elm.observeRules(GCLMS.Triggers.get('.gclms-viewport-content'));
			return true;
		}
		
		Ext.get('booksViewportContent').load({
			url: elm.dom.getAttribute('loaded:url'),
			text: '&nbsp;',
			callback: GCLMS.Triggers.get('.gclms-viewport-content')[':updated'].bind(elm)
		});
	},
	
	gotoBibleLink: function() {
		event.stop();
		
		elm = Ext.get('bibleViewportContent');
		hrefParts = this.getAttribute('href').split('#');
		href = hrefParts[0];
		
		elm.dom.setAttribute('loaded:url', hrefParts[0]);
		
		Ext.getCmp('bibleViewport').expand();
		
		if (GCLMS.cache.get(href)) {
			elm.update(GCLMS.cache.get(href));
			$(elm.dom).observeRules(GCLMS.Triggers.get('.gclms-viewport-content'));
			el = $('bibleVerse' + hrefParts[1]);
			el.addClassName('gclms-selected');
			$('bibleViewportContent').parentNode.scrollTop = el.cumulativeOffset()[1] - $(el.parentNode).cumulativeOffset()[1];
			return true;
		}
		
		Ext.get('bibleViewportContent').load({
			url: elm.dom.getAttribute('loaded:url'),
			text: '&nbsp;',
			hrefParts: hrefParts,
			callback: function(elm){
				$(elm.dom).observeRules(GCLMS.Triggers.get('.gclms-viewport-content'));
				GCLMS.cache.set(this.hrefParts[0], $('bibleViewportContent').innerHTML)
				if (this.hrefParts[1]) {
					el = $('bibleVerse' + this.hrefParts[1]);
					el.addClassName('gclms-selected');
					$('bibleViewportContent').parentNode.scrollTop = el.cumulativeOffset()[1] - $(el.parentNode).cumulativeOffset()[1];
				}
			}
		});
	},
	
	toggleNodeExpansion: function() {
		var li = this.up('li');

		if(li.hasClassName('gclms-collapsed')) {
			/*
			$$('#' + li.getAttribute('id') + ' > ul > li').each(function(node){
				node.displayAsBlock();
			});
			*/
			li.removeClassName('gclms-collapsed');
			li.addClassName('gclms-expanded');
		} else if(li.hasClassName('gclms-expanded')) {
			/*
			$$('#' + li.getAttribute('id') + ' > ul > li').each(function(node){
				node.hide();
			});			
			*/
			li.addClassName('gclms-collapsed');
			li.removeClassName('gclms-expanded');
		}
	},
	
	toggleNodeExpansion: function() {
		var li = this.up('li');

		if(li.hasClassName('gclms-collapsed')) {
			/*
			$$('#' + li.getAttribute('id') + ' > ul > li').each(function(node){
				node.displayAsBlock();
			});
			*/
			li.removeClassName('gclms-collapsed');
			li.addClassName('gclms-expanded');
		} else if(li.hasClassName('gclms-expanded')) {
			/*
			$$('#' + li.getAttribute('id') + ' > ul > li').each(function(node){
				node.hide();
			});			
			*/
			li.addClassName('gclms-collapsed');
			li.removeClassName('gclms-expanded');
		}
	}
};

GCLMS.Triggers.update({
	'div.gclms-classroom-viewport': GCLMS.ClassroomController.loadViewport,
	'#bibleViewport:expand': GCLMS.ClassroomController.expandBibleViewport,
	'#booksViewport:expand': GCLMS.ClassroomController.expandBooksViewport,
	'#articlesViewport:expand': GCLMS.ClassroomController.expandArticlesViewport,
	'#glossaryViewport:expand' : GCLMS.ClassroomController.expandGlossaryViewport,
	'.gclms-viewport-content' : {
		':updated' : function () {
			elm = this.dom;
			$(elm).observeRules(GCLMS.Triggers.get('.gclms-viewport-content'));
		},
		'a:click' : GCLMS.ClassroomController.gotoViewportLink
	},
	'#chatTab:activate' : GCLMS.ClassroomController.activateChatTab,
	'#discussionTab:activate' : GCLMS.ClassroomController.activateDiscussionTab,
	'#notebookTab:activate' : GCLMS.ClassroomController.activateNotebookTab,
	'.page': {
		'a[href*="/articles/"]:click': GCLMS.ClassroomController.gotoArticleLink,
		'a[href*="/chapters/"]:click': GCLMS.ClassroomController.gotoBookLink,
		'a[href*="bible_"]:click': GCLMS.ClassroomController.gotoBibleLink,
		'#pageNavigation a:click': function(event){
			event.stop();
			
			Ext.get('lessonTabContent').load({
				url: this.getAttribute('href'),
				text: '&nbsp;',
				callback: function(elm){
					$(elm.dom).observeRules(GCLMS.Triggers.get('.page'));
				}
			});
			
			return false;
		}
	},
	'#gclms-nodes-tree li': {
		'img.gclms-expand-button:click' : GCLMS.ClassroomController.toggleNodeExpansion,
		'a:click' : GCLMS.ClassroomController.gotoPageLink
	}
});

/*
if($('pageNavigation')) {
	try {
		sidebarContent = parent.frames['sidebarContent'];
		//alert(location.href);
		sidebarContent.$$('a.selected').each(function(a){
			a.removeClassName('selected');
		})

		locationSplitResults = location.href.split('lesson:');
		a = sidebarContent.$$('a[href*="' + locationSplitResults[1] + '"]').each(function(node){
			node.className = 'selected';
		});
	} catch(e){}
	//alert('a[href$="' + locationSplitResults[1] + '"]');
}
*/