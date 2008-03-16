GCLMS.ChaptersController = {
	select: function(event) {
		event.stop();
	
		$$('#chapters a').each(function(node){
			node.removeClassName('selected');
		});
		if(!this.addClassName)
			return false;
	
		this.addClassName('selected');
	
		$$('#gclms-menubar button').each(function(button){
			button.enable();
		});
	},
	getTitleForAddition: function() {
		GCLMS.popup.create({
			text: this.down('button').getAttribute('prompt:text'),
			callback: GCLMS.ChaptersController.add
		});
		return false;
	},
	add: function(title) {
		if(!title)
			return false;
		tmpChapterId = UUID.generate();
	
		$('chapters').insert(GCLMS.Views.get('chapter').interpolate({
			id: tmpChapterId,
			title: title
		}));

		GCLMS.Chapter.add({
			bookId: $('chapters').getAttribute('book:id'),
			title: title,
			callback: function(request) {
				$('chapter_' + tmpChapterId).setAttribute('chapter:id',request.responseText);
				$('chapter_' + tmpChapterId).observeRules(GCLMS.Triggers.get('#chapters'));
			}
		});	
	},
	getTitleForRename: function() {
		GCLMS.popup.create({
			text: this.down('button').getAttribute('prompt:text'),
			value: $$('#chapters a.selected').first().innerHTML,
			callback: GCLMS.ChaptersController.rename
		});
	},
	rename: function(title) {
		a = $$('#chapters a.selected').first();
		
		if(!title || a.innerHTML == title)
			return false;

		a.innerHTML = title;

		GCLMS.Chapter.rename({
			id: a.up('li').getAttribute('chapter:id'),
			title: title
		});
	},
	confirmDelete: function() {
		GCLMS.popup.create({
			text: this.down('button').getAttribute('gclms:confirm-text'),
			confirmButtonText: __('Yes'),
			cancelButtonText: __('No'),
			type: 'confirm',
			callback: GCLMS.ChaptersController.remove
		});
		return false;		
	},
	remove: function() {	
		li = $$('#chapters a.selected').first().up('li');
		
		GCLMS.Chapter.remove({id: li.getAttribute('chapter:id')});
	
		li.remove();
	
		$$('#renameChapter > button').first().disable();
		$$('#deleteChapter > button').first().disable();
		$$('#editChapter > button').first().disable();
	},
	edit: function(event){
		self.location = '/' + document.body.getAttribute('lms:group') + '/' + document.body.getAttribute('lms:course') + '/chapters/edit/' + $$('#chapters a.selected').first().up('li').getAttribute('chapter:id');
	},
	createSortables: function() {
		Sortable.create($('chapters'),{
			scroll: window,
			onUpdate: GCLMS.ChaptersController.reorder
		});
	},
	reorder: function() {
		chapterIds = new Array();
		$('chapters').select('li').each(function(li){
			chapterIds.push(li.getAttribute('chapter:id'));
		});
		GCLMS.Chapter.reorder({
			bookId: $('chapters').getAttribute('book:id'),
			chapterIds: chapterIds
		});
	}
}

GCLMS.Chapter = {
	ajaxUrl: '/' + document.body.getAttribute('lms:group') + '/' + document.body.getAttribute('lms:course') + '/chapters/',
	add: function(options) {
		new Ajax.Request(this.ajaxUrl + 'add',{
			method: 'post',
			parameters: {
				'data[Chapter][title]': options.title,
				'data[Chapter][book_id]': options.bookId
			},
			onComplete: options.callback
		});	
	},
	rename: function(options) {
		new Ajax.Request(this.ajaxUrl + 'rename/' + options.id,{
			method: 'post',
			parameters: {
				'data[Chapter][title]': options.title
			}
		});
	},
	remove: function(options) {
		new Ajax.Request(this.ajaxUrl + 'delete/' + options.id);
	},
	reorder: function(options) {
		new Ajax.Request(this.ajaxUrl + 'reorder',{
			method: 'post',
			parameters: {
				'data[Book][id]': options.bookId,
				'data[Book][chapters]': options.chapterIds.toString()
			}
		});
	}
}

GCLMS.Views.update({
	chapter: '<li id="chapter_#{id}"><a href="#">#{title}</a></li>'
});

GCLMS.Triggers.update({
	'#gclms-menubar' : {
		'#editChapter:click':		GCLMS.ChaptersController.edit,
		'#deleteChapter:click':		GCLMS.ChaptersController.confirmDelete,
		'#addChapter:click':		GCLMS.ChaptersController.getTitleForAddition,
		'#renameChapter:click':		GCLMS.ChaptersController.getTitleForRename
	},

	'#chapters' : {
		':loaded':					GCLMS.ChaptersController.createSortables,
		'a' : {
			':click':				GCLMS.ChaptersController.select,
			':dblclick':			GCLMS.ChaptersController.edit
		}
	}
});