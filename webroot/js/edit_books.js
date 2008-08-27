gclms.BooksController = {
	gotoFramedChapter: function(event) {
		event.stop();
		location.href = this.getAttribute('href') + '?framed';
	},
	
	editBook: function() {
		self.location = '/' + document.body.getAttribute('gclms:group') + '/' + document.body.getAttribute('gclms:course') + '/chapters/toc/' + $$('#books a.selected').first().up('li').getAttribute('book:id');		
	},
	selectBook: function(event) {
		event.stop();

		$$('#books a').each(function(node){
			node.removeClassName('selected');
		});
		if(!this.addClassName) {
			return false;
		}

		this.addClassName('selected');

		$$('#gclms-menubar button').each(function(button){
			button.enable();
		});
	},
	
	// New functions
		
	getChapterTitleForAddition: function() {
		gclms.popup.create({
			text: this.getAttribute('gclms:prompt-text'),
			callback: gclms.BooksController.addChapter.bind(this)
		});
		return false;
	},

	addChapter: function(title) {
		if(!title)
			return false;	
	
		var div = this.up('.gclms-book');
				
		var tmpChapterId = UUID.generate();
	
		div.down('ul').insert(gclms.Views.get('chapter').interpolate({
			id: tmpChapterId,
			title: title
		}));

		gclms.Chapter.add({
			bookId: div.getAttribute('gclms:id'),
			title: title,
			callback: function(request) {
				$('chapter_' + tmpChapterId).setAttribute('gclms:id',request.responseText);
				$('chapter_' + tmpChapterId).down('a').setAttribute('href',gclms.urlPrefix + 'chapters/view/' + request.responseText);
				//$('chapter_' + tmpChapterId).observeRules(gclms.Triggers.get('#chapters'));
			}
		});	
	},
	
	getBookTitleForRename: function() {
		gclms.popup.create({
			text: this.getAttribute('gclms:prompt-text'),
			value: this.up('.gclms-book').down('h2').innerHTML,
			callback: gclms.BooksController.renameBook.bind(this)
		});
	},
	
	renameBook: function(title) {
		var h2 = this.up('.gclms-book').down('h2');

		if(!title || h2.innerHTML == title) {
			return false;
		}

		h2.innerHTML = title;

		gclms.Book.rename({
			id: this.up('.gclms-book').getAttribute('gclms:id'),
			title: title
		});
	},
	
	confirmDeleteBook: function() {
		gclms.popup.create({
			text: this.getAttribute('gclms:confirm-text'),
			confirmButtonText: __('Yes'),
			cancelButtonText: __('No'),
			type: 'confirm',
			callback: gclms.BooksController.deleteBook.bind(this)
		});
		return false;
	},

	deleteBook: function() {
		var div = this.up('.gclms-book');
		gclms.Book.remove({id: div.getAttribute('gclms:id')});
		div.remove();
	}

};

gclms.Book = {
	ajaxUrl: '/' + document.body.getAttribute('gclms:group') + '/' + document.body.getAttribute('gclms:course') + '/books/',
	add: function(options) {		request = new Ajax.Request(this.ajaxUrl + 'add/' + options.id,{
			method: 'post',
			parameters: {
				'data[Book][title]': options.title
			},
			onComplete: options.callback
		});			

	},
	remove: function(options) {
		request = new Ajax.Request(this.ajaxUrl + 'delete/' + options.id);
	},
	rename: function(options) {
		request = new Ajax.Request(this.ajaxUrl + 'rename/' + options.id,{
			method: 'post',
			parameters: {
				'data[Book][title]': options.title
			}
		});			
	}
};

gclms.Chapter = {
	ajaxUrl: '/' + document.body.getAttribute('gclms:group') + '/' + document.body.getAttribute('gclms:course') + '/chapters/',
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
	chapter: '<li id="chapter_#{id}"><a>#{title}</a></li>'
});

gclms.Triggers.update({
	'#gclms-books' : {
		'.gclms-book' : {
			'.gclms-add:click': gclms.BooksController.getChapterTitleForAddition,
			'.gclms-rename:click': gclms.BooksController.getBookTitleForRename,
			'.gclms-delete:click': gclms.BooksController.confirmDeleteBook
		}
	},
	
	'.gclms-framed .gclms-book li a:click,.gclms-framed .gclms-step-back a:click': gclms.BooksController.gotoFramedChapter
});