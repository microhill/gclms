gclms.ChaptersController = {
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
		gclms.popup.create({
			text: this.down('button').getAttribute('gclms:prompt-text'),
			callback: gclms.ChaptersController.add
		});
		return false;
	},
	add: function(title) {
		if(!title)
			return false;
		tmpChapterId = UUID.generate();
	
		$('chapters').insert(gclms.Views.get('chapter').interpolate({
			id: tmpChapterId,
			title: title
		}));

		gclms.Chapter.add({
			bookId: $('chapters').getAttribute('book:id'),
			title: title,
			callback: function(request) {
				$('chapter_' + tmpChapterId).setAttribute('chapter:id',request.responseText);
				$('chapter_' + tmpChapterId).observeRules(gclms.Triggers.get('#chapters'));
			}
		});	
	},
	getTitleForRename: function() {
		gclms.popup.create({
			text: this.down('button').getAttribute('gclms:prompt-text'),
			value: $$('#chapters a.selected').first().innerHTML,
			callback: gclms.ChaptersController.rename
		});
	},
	rename: function(title) {
		a = $$('#chapters a.selected').first();
		
		if(!title || a.innerHTML == title)
			return false;

		a.innerHTML = title;

		gclms.Chapter.rename({
			id: a.up('li').getAttribute('chapter:id'),
			title: title
		});
	},
	confirmDelete: function() {
		gclms.popup.create({
			text: this.down('button').getAttribute('gclms:confirm-text'),
			confirmButtonText: __('Yes'),
			cancelButtonText: __('No'),
			type: 'confirm',
			callback: gclms.ChaptersController.remove
		});
		return false;		
	},
	remove: function() {	
		li = $$('#chapters a.selected').first().up('li');
		
		gclms.Chapter.remove({id: li.getAttribute('chapter:id')});
	
		li.remove();
	
		$$('#renameChapter > button').first().disable();
		$$('#deleteChapter > button').first().disable();
		$$('#editChapter > button').first().disable();
	},
	edit: function(event){
		self.location = '/' + document.body.getAttribute('gclms-group') + '/' + document.body.getAttribute('gclms-course') + '/chapters/edit/' + $$('#chapters a.selected').first().up('li').getAttribute('chapter:id');
	},
	createSortables: function() {
		Sortable.create($('chapters'),{
			scroll: window,
			onUpdate: gclms.ChaptersController.reorder
		});
	},
	reorder: function() {
		chapterIds = new Array();
		$('chapters').select('li').each(function(li){
			chapterIds.push(li.getAttribute('chapter:id'));
		});
		gclms.Chapter.reorder({
			bookId: $('chapters').getAttribute('book:id'),
			chapterIds: chapterIds
		});
	}
}

gclms.Chapter = {
	ajaxUrl: '/' + document.body.getAttribute('gclms-group') + '/' + document.body.getAttribute('gclms-course') + '/chapters/',
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

gclms.Views.update({
	chapter: '<li id="chapter_#{id}"><a href="#">#{title}</a></li>'
});

gclms.Triggers.update({
	'#gclms-menubar' : {
		'#editChapter:click':		gclms.ChaptersController.edit,
		'#deleteChapter:click':		gclms.ChaptersController.confirmDelete,
		'#addChapter:click':		gclms.ChaptersController.getTitleForAddition,
		'#renameChapter:click':		gclms.ChaptersController.getTitleForRename
	},

	'#chapters' : {
		':loaded':					gclms.ChaptersController.createSortables,
		'a' : {
			':click':				gclms.ChaptersController.select,
			':dblclick':			gclms.ChaptersController.edit
		}
	}
});