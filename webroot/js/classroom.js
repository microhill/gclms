GCLMS.classroom = {};

GCLMS.Triggers.update({
	'#bibleViewport:expand' : function(elm) {
		url = '/' + document.body.getAttribute('lms:group') + '/' + document.body.getAttribute('lms:course') + '/bible_kjv/books';
		if(!Ext.get('bibleViewportContent').loaded)
			Ext.get('bibleViewportContent').dom.src = url;
		Ext.get('bibleViewportContent').loaded = true;
	},
	'#textbooksViewport:expand' : function(elm) {
		url = '/' + document.body.getAttribute('lms:group') + '/' + document.body.getAttribute('lms:course') + '/textbooks/panel';
		if(!Ext.get('textbooksViewportContent').loaded)
			Ext.get('textbooksViewportContent').dom.src = url;
		Ext.get('textbooksViewportContent').loaded = true;
	},
	'#articlesViewport:expand' : function(elm) {
		url = '/' + document.body.getAttribute('lms:group') + '/' + document.body.getAttribute('lms:course') + '/articles/panel';
		if(!Ext.get('articlesViewportContent').loaded)
			Ext.get('articlesViewportContent').dom.src = url;
		Ext.get('articlesViewportContent').loaded = true;
	},
	'#dictionaryViewport:expand' : function(elm) {
		url = '/' + document.body.getAttribute('lms:group') + '/' + document.body.getAttribute('lms:course') + '/dictionary/panel';
		if(!Ext.get('dictionaryViewportContent').loaded)
			Ext.get('dictionaryViewportContent').dom.src = url;
		Ext.get('dictionaryViewportContent').loaded = true;
	},
	'.gclms-viewport-content' : {
		':updated' : function () {
			elm = this.dom;
			$(elm).observeRules(GCLMS.Triggers.get('.gclms-viewport-content'));
		},
		'a:click' : function(event) {
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
		}
	},
	'#chatTab:activate' : function(elm) {
		//alert(elm);
	},
	'#discussionTab:activate' : function(elm) {
		url = '/' + document.body.getAttribute('lms:group') + '/' + document.body.getAttribute('lms:course') + '/' + document.body.getAttribute('lms:facilitated_class') + '/discussion/forums';
		currentSrc = Ext.get('discussionViewportContent').dom.src;
		if(currentSrc.indexOf(url) == -1) {
			Ext.get('discussionViewportContent').dom.src = url;
		}
		
		return true;
	},
	'#notebookTab:activate' : function(elm) {
		url = '/' + document.body.getAttribute('lms:group') + '/' + document.body.getAttribute('lms:course') + '/' + document.body.getAttribute('lms:facilitated_class') + '/notebook/edit';
		currentSrc = Ext.get('notebookViewportContent').dom.src;
		if(currentSrc.indexOf(url) == -1) {
			Ext.get('notebookViewportContent').dom.src = url;
		}
		
		return true;
	},
	'.gclms-lesson-navigation' : {
		'img.gclms-expanded:click,img.gclms-collapsed:click' : function(event) {
			event.stop();
			GCLMS.Triggers.get('.gclms-lesson-navigation')['a:click'].bind($(this.next('a')))(event);
		},
		'a:click' : function(event) {
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
			$$('a.selected').each(function(node){
				node.removeClassName('selected');
			})
			if(this.addClassName)
				this.addClassName('selected');
					
			Ext.getCmp('classroomTabs').activate('lessonTab');
		}
	},
	'.page': {
		'a[href*="/articles/"]:click': function(event){
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
		'a[href*="/chapters/"]:click': function(event){
			event.stop();
			
			elm = Ext.get('textbooksViewportContent');
			
			href = this.getAttribute('href');
			elm.dom.setAttribute('loaded:url', href);
			
			Ext.getCmp('textbooksViewport').expand();
			
			if (GCLMS.cache.get(href)) {
				elm.update(GCLMS.cache.get(href));
				elm.observeRules(GCLMS.Triggers.get('.gclms-viewport-content'));
				return true;
			}
			
			Ext.get('textbooksViewportContent').load({
				url: elm.dom.getAttribute('loaded:url'),
				text: '&nbsp;',
				callback: GCLMS.Triggers.get('.gclms-viewport-content')[':updated'].bind(elm)
			});
		},
		'a[href*="bible_"]:click': function(event){
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