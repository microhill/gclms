GCLMS.BooksController = {
	getBookTitleForAddition: function() {
		GCLMS.popup.create({
			text: this.down('button').getAttribute('prompt:text'),
			callback: GCLMS.BooksController.addBook
		});
		return false;
	},
	addBook: function(title) {
		if(!title) {
			return false;			
		}
		tmpBookId = UUID.generate();

		$('books').insert(GCLMS.Views.get('book').interpolate({
			id: tmpBookId,
			title: title
		}));

		GCLMS.Book.add({
			title: title,
			callback: function(request) {
				$('book_' + tmpBookId).setAttribute('book:id',request.responseText);
				$('book_' + tmpBookId).observeRules(GCLMS.Triggers.get('#books'));
			}
		});
	},
	editBook: function() {
		self.location = '/' + document.body.getAttribute('lms:group') + '/' + document.body.getAttribute('lms:course') + '/chapters/toc/' + $$('#books a.selected').first().up('li').getAttribute('book:id');		
	},
	confirmDeleteBook: function() {
		GCLMS.popup.create({
			text: this.down('button').getAttribute('confirm:text'),
			confirmButtonText: __('Yes'),
			cancelButtonText: __('No'),
			type: 'confirm',
			callback: GCLMS.BooksController.deleteBook
		});
		return false;
	},
	deleteBook: function() {
		li = $$('#books a.selected').first().up('li');

		GCLMS.Book.remove({id: li.getAttribute('book:id')});

		li.remove();

		$$('#renameBook > button').first().disable();
		$$('#deleteBook > button').first().disable();
		$$('#editBook > button').first().disable();
	},
	getBookTitleForRename: function() {
		GCLMS.popup.create({
			text: this.down('button').getAttribute('prompt:text'),
			value: $$('#books a.selected').first().innerHTML,
			callback: GCLMS.BooksController.renameBook
		});
	},
	renameBook: function(title) {
		a = $$('#books a.selected').first();

		if(!title || a.innerHTML == title) {
			return false;
		}

		a.innerHTML = title;

		GCLMS.Book.rename({
			id: a.up('li').getAttribute('book:id'),
			title: title
		});
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
	}
};

GCLMS.Book = {
	ajaxUrl: '/' + document.body.getAttribute('lms:group') + '/' + document.body.getAttribute('lms:course') + '/books/',
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

GCLMS.Views.update({
	book: '<li id="book_#{id}"><a href="#">#{title}</a></li>'
});

GCLMS.Triggers.update({
	'#gclms-menubar' : {
		'#editBook:click':		GCLMS.BooksController.editBook,
		'#deleteBook:click':	GCLMS.BooksController.confirmDeleteBook,
		'#addBook:click':		GCLMS.BooksController.getBookTitleForAddition,
		'#renameBook:click': 	GCLMS.BooksController.getBookTitleForRename
	},

	'#books' : {
		'a' : {
			':click': 				GCLMS.BooksController.selectBook,
			':dblclick': 			GCLMS.BooksController.editBook
		}
	}
});