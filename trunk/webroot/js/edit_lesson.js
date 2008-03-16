GCLMS.LessonController = {
	selectTopic: function(event) {
		event.stop();
	
		$$('#lesson a').each(function(node){
			node.removeClassName('selected');
		});
		this.addClassName('selected');
	
		$$('.buttons button').each(function(node){
			node.hide();
		});
		$('addTopic').displayAsInline();
		$('addPage').displayAsInline();
		$('editTopic').displayAsInline();
		if(this.up('div').getAttribute('id') != 'uncategorizedPagesContainer') {
			$('renameTopic').displayAsInline();
			$('deleteTopic').displayAsInline();
		}
	},

	editPage: function(event) {	
		self.location = '/' + document.body.getAttribute('lms:group') + '/' + document.body.getAttribute('lms:course')
				+ '/pages/edit/' + $$('a.selected').first().up('li').getAttribute('page:id');
	},
	getPageTitleForAddition: function() {
		GCLMS.popup.create({
			text: 'Enter the title of the page:',
			callback: GCLMS.LessonController.addPage
		});
		return false;
	},
	addPage: function(title) {
		if(!title)
			return false;
		tmpPageId = UUID.generate();

		// Get list associated either with selected h2 or selected anchor
		selectedTopic = $$('h2 a.selected');

		if(selectedTopic.length) {
			ul = selectedTopic.first().up('div').select('ul').first();
		} else {
			anchors = $$('a.selected');
			if(anchors.length) {
				ul = anchors.first().findParent('ul');
			} else {
				ul = $('uncategorizedPagesList');
			}
		}

		ul.insert(GCLMS.Views.get('page').interpolate({
			id: tmpPageId,
			title: title
		}));			
		
		GCLMS.Page.add({
			title: title,
			lessonId: $('lesson').getAttribute('lesson:id'),
			topicId: ul.up('div').getAttribute('page:id'),
			topicHead: 0,
			callback: function(request) {
				$('page_' + tmpPageId).setAttribute('page:id',request.responseText);
				$('page_' + tmpPageId).observeRules(GCLMS.Triggers.get('#lesson')['.topicPages']);
				GCLMS.LessonController.createSortables();
			}
		});
	},
	getPageTitleForRename: function() {
		GCLMS.popup.create({
			text: this.getAttribute('prompt:text'),
			callback: GCLMS.LessonController.renamePage,
			value: $$('#lesson a.selected').first().innerHTML
		});
		return false;
	},
	renamePage: function(title) {	
		a = $$('#lesson a.selected').first();
	
		if(!title || a.innerHTML == title)
			return false;
	
		a.innerHTML = title;
		
		GCLMS.Page.rename({
			title: title,
			id: a.up('li').getAttribute('page:id')
		});
	},
	confirmDeletePage: function() {
		GCLMS.popup.create({
			text: this.getAttribute('gclms:confirm-text'),
			confirmButtonText: __('Yes'),
			cancelButtonText: __('No'),
			type: 'confirm',
			callback: GCLMS.LessonController.deletePage
		});
		return false;
	},
	deletePage: function() {	
		li = $$('#lesson a.selected').first().up('li');
		GCLMS.Page.remove({id: li.getAttribute('page:id')});	
		li.remove();
	
		$('renamePage').hide();
		$('editPage').hide();
		$('deletePage').hide();
	},
	getTopicTitleForAddition: function() {
		GCLMS.popup.create({
			text: 'Enter the title of the topic:',
			callback: GCLMS.LessonController.addTopic
		});
		return false;
	},
	addTopic: function(title) {
		if(!title)
			return title;
		tmpTopicId = UUID.generate();
		
		$('topics').insert(GCLMS.Views.get('topic').interpolate({
			id: tmpTopicId,
			title: title
		}));
		$('uncategorizedPagesHeader').displayAsBlock();
		
		GCLMS.Page.add({
			title: title,
			lessonId: $('lesson').getAttribute('lesson:id'),
			topicId: 0,
			topicHead: 1,
			callback: function(request) {
				newId = request.responseText;
				$('topic_' + tmpTopicId).setAttribute('page:id',newId);
				$('topic_' + tmpTopicId).observeRules(GCLMS.Triggers.get('#lesson'));
			}
		});
	},
	getTopicTitleForRename: function() {
		GCLMS.popup.create({
			text: this.getAttribute('prompt:text'),
			callback: GCLMS.LessonController.renameTopic,
			value: $$('#lesson h2 a.selected').first().innerHTML
		});
		return false;
	},
	renameTopic: function(title) {
		a = $$('#lesson h2 a.selected').first();
		
		if(!title || a.innerHTML == title)
			return false;

		a.innerHTML = title;	
		
		GCLMS.Page.rename({
			title: title,
			id: a.up('div').getAttribute('page:id')
		});
	},
	confirmDeleteTopic: function() {
		if($$('#lesson h2 a.selected').first().up('div.topic').down('ul.topicPages').select('a').length) {
			GCLMS.popup.create({
				text: this.getAttribute('notempty:message'),
				cancelButtonText: null,
				type: 'alert'
			});
			return false;
		}

		GCLMS.popup.create({
			text: this.getAttribute('gclms:confirm-text'),
			confirmButtonText: __('Yes'),
			cancelButtonText: __('No'),
			type: 'confirm',
			callback: GCLMS.LessonController.deleteTopic
		});
		return false;
	},
	deleteTopic: function() {
		a = $$('#lesson h2 a.selected').first();

		GCLMS.Page.remove({id: a.up('div.topic').getAttribute('page:id')});

		a.up('div.topic').remove();

		if(!$$('#topics div').length)
			$('uncategorizedPagesHeader').hide();

		$('renameTopic').hide();
		$('deleteTopic').hide();
	},
	selectPage: function(event) {
		$$('#lesson a').each(function(node){
			node.removeClassName('selected');
		});
		$$('#lesson h2').each(function(node){
			node.removeClassName('selected');
		});
		if(!this.addClassName)
			return false;
	
		this.addClassName('selected');
	
		$$('#lesson button').each(function(node){
			node.hide();
		});
	
		$('addTopic').displayAsInline();
		$('addPage').displayAsInline();
		$('renamePage').displayAsInline();
		$('deletePage').displayAsInline();
		$('editPage').displayAsInline();
	
		event.stop();
	},
	editTopic : function(event) {
		self.location = '/' + document.body.getAttribute('lms:group')
			+ '/' + document.body.getAttribute('lms:course')
			+ '/pages/edit/' + $$('a.selected').first().up('div.topic').getAttribute('page:id');
	},
	createSortables: function() {
		lessonContainers = $$('#lesson ul');
	
		lessonContainers.each(function(node) {
			Sortable.create(node.getAttribute('id'),{
				containment: lessonContainers,
				dropOnEmpty: true,
				scroll: window,
				onUpdate: GCLMS.LessonController.reorderWithinTopic
			});
		});
	
		Sortable.create('topics',{
			handle: 'topicHandle',
			tag: 'div',
			scroll: window,
			onUpdate: GCLMS.LessonController.reorderTopics
		});		
	},
	reorderTopics: function(element) {
		topicIds = new Array();
		$$('#topics div').each(function(node){
			topicIds.push(node.getAttribute('page:id'));
		});
	
		GCLMS.Page.reorderTopics({
			topicIds: topicIds,
			lessonId: $('lesson').getAttribute('lesson:id')
		});
	},
	reorderWithinTopic: function(element) {
		pageIds = new Array();
		element.select('li').each(function(node){
			pageIds.push(node.getAttribute('page:id'));
		});
		GCLMS.Page.reorderWithinTopic({
			topicId: element.up('div.topic').getAttribute('page:id'),
			pageIds: pageIds
		});
	}
};

GCLMS.Page = {
	ajaxUrl: '/' + document.body.getAttribute('lms:group') + '/' + document.body.getAttribute('lms:course') + '/pages/',
	add: function(options) {
		new Ajax.Request(this.ajaxUrl + 'add',{
			method: 'post',
			parameters: {
				'data[Page][lesson_id]': options.lessonId,
				'data[Page][topic_id]': options.topicId,
				'data[Page][title]': options.title,
				'data[Page][topic_head]': options.topicHead
			},
			onComplete: options.callback
		});		
	},
	rename: function(options) {
		new Ajax.Request(this.ajaxUrl + 'rename/' + options.id,{
			method: 'post',
			parameters: {
				'data[Page][title]': options.title
			}
		});	
	},
	remove: function(options){
		new Ajax.Request(this.ajaxUrl + 'delete/' + options.id);
	},
	reorderWithinTopic: function(options) {
		new Ajax.Request(this.ajaxUrl + 'reorder',{
			method: 'post',
			parameters: {
				'data[Topic][pages]': options.pageIds.toString(),
				'data[Topic][id]': options.topicId
			}
		});
	},
	reorderTopics: function(options) {
		new Ajax.Request(this.ajaxUrl + 'reorder',{
			parameters: {
				'data[Lesson][topics]': options.topicIds.toString(),
				'data[Lesson][id]': options.lessonId
			}
		});
	}
};

GCLMS.Views.update({
	topic: '<div id="topic_#{id}" class="topic"><h2 cl="topicHandle" id="topicHandle_#{id}"><a href="#">#{title}</a></h2><ul id="topicPages_#{id}" class="topicPages">#{pages}</ul></div>',
	page: '<li id="page_#{id}"><a href="#">#{title}</a></li>'
});

GCLMS.Triggers.update({
	'#lesson' : {
		':loaded':				GCLMS.LessonController.createSortables,
		'h2 a' : {
			':click':			GCLMS.LessonController.selectTopic,
			':dblclick':		GCLMS.LessonController.editTopic
		},

		'.topicPages' : {
			'a' : {
				':click':		GCLMS.LessonController.selectPage,
				':dblclick':	GCLMS.LessonController.editPage
			}
		}
	},

	'.buttons': {
		'#addPage:click': 		GCLMS.LessonController.getPageTitleForAddition,
		'#addTopic:click': 		GCLMS.LessonController.getTopicTitleForAddition,
		'#deleteTopic:click':	GCLMS.LessonController.confirmDeleteTopic,
		'#deletePage:click': 	GCLMS.LessonController.confirmDeletePage,
		'#renameTopic:click': 	GCLMS.LessonController.getTopicTitleForRename,
		'#renamePage:click': 	GCLMS.LessonController.getPageTitleForRename,
		'#editPage:click': 		GCLMS.LessonController.editPage,
		'#editTopic:click':		GCLMS.LessonController.editTopic
	}
});
