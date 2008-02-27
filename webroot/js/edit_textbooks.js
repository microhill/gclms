GCLMS.TextbooksController = {
	getTextbookTitleForAddition: function() {
		GCLMS.popup.create({
			text: this.getAttribute('prompt:text'),
			callback: GCLMS.TextbooksController.addTextbook
		});
		return false;
	},
	addTextbook: function(title) {
		if(!title) {
			return false;			
		}
		tmpTextbookId = UUID.generate();

		$('textbooks').insert(GCLMS.Views.get('textbook').interpolate({
			id: tmpTextbookId,
			title: title
		}));

		GCLMS.Textbook.add({
			title: title,
			callback: function(request) {
				$('textbook_' + tmpTextbookId).setAttribute('textbook:id',request.responseText);
				$('textbook_' + tmpTextbookId).observeRules(GCLMS.Triggers.get('#textbooks'));
			}
		});
	},
	editTextbook: function() {
		self.location = '/' + document.body.getAttribute('lms:group') + '/' + document.body.getAttribute('lms:course') + '/chapters/toc/' + $$('#textbooks a.selected').first().up('li').getAttribute('textbook:id');		
	},
	confirmDeleteTextbook: function() {
		GCLMS.popup.create({
			text: this.getAttribute('confirm:text'),
			confirmButtonText: __('Yes'),
			cancelButtonText: __('No'),
			type: 'confirm',
			callback: GCLMS.TextbooksController.deleteTextbook
		});
		return false;
	},
	deleteTextbook: function() {
		li = $$('#textbooks a.selected').first().up('li');

		GCLMS.Textbook.remove({id: li.getAttribute('textbook:id')});

		li.remove();

		$('renameTextbook').hide();
		$('deleteTextbook').hide();
		$('editTextbook').hide();
	},
	getTextbookTitleForRename: function() {
		GCLMS.popup.create({
			text: this.getAttribute('prompt:text'),
			value: $$('#textbooks a.selected').first().innerHTML,
			callback: GCLMS.TextbooksController.renameTextbook
		});
	},
	renameTextbook: function(title) {
		a = $$('#textbooks a.selected').first();

		if(!title || a.innerHTML == title) {
			return false;
		}

		a.innerHTML = title;

		GCLMS.Textbook.rename({
			id: a.up('li').getAttribute('textbook:id'),
			title: title
		});
	},
	selectTextbook: function(event) {
		event.stop();

		$$('#textbooks a').each(function(node){
			node.removeClassName('selected');
		});
		if(!this.addClassName) {
			return false;
		}

		this.addClassName('selected');

		$$('.buttons button').each(function(node){
			node.hide();
		});
		$('addTextbook').displayAsInline();
		$('renameTextbook').displayAsInline();
		$('deleteTextbook').displayAsInline();
		$('editTextbook').displayAsInline();
	}
};

GCLMS.Textbook = {
	ajaxUrl: '/' + document.body.getAttribute('lms:group') + '/' + document.body.getAttribute('lms:course') + '/textbooks/',
	add: function(options) {		request = new Ajax.Request(this.ajaxUrl + 'add/' + options.id,{
			method: 'post',
			parameters: {
				'data[Textbook][title]': options.title
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
				'data[Textbook][title]': options.title
			}
		});			
	}
};

GCLMS.Views.update({
	textbook: '<li id="textbook_#{id}"><a href="#">#{title}</a></li>'
});

GCLMS.Triggers.update({
	'.buttons' : {
		'#editTextbook:click':		GCLMS.TextbooksController.editTextbook,
		'#deleteTextbook:click':	GCLMS.TextbooksController.confirmDeleteTextbook,
		'#addTextbook:click':		GCLMS.TextbooksController.getTextbookTitleForAddition,
		'#renameTextbook:click': 	GCLMS.TextbooksController.getTextbookTitleForRename
	},

	'#textbooks' : {
		'a' : {
			':click': 				GCLMS.TextbooksController.selectTextbook,
			':dblclick': 			GCLMS.TextbooksController.editTextbook
		}
	}
});