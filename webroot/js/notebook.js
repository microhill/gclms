gclms.NotebookController = {
	addEntry: function(event) {
		event.stop();
		
		if($F('gclms-new-entry-title').empty()) {
			alert('Title cannot be empty.');
			return false;
		}
		
		if($F('gclms-new-entry-content').empty()) {
			alert('Entry cannot be empty.');
			return false;
		}
		
		var id = UUID.generate();
		$('gclms-notebook-entries').insert({top: gclms.Views.get('notebook_entry').interpolate({
			title: 'Saving...',
			content: $F('gclms-new-entry-content'),
			id: id 
		})});

		gclms.NotebookEntry.add({
			title: $F('gclms-new-entry-title'),
			content: $F('gclms-new-entry-content'),
			callback: function(transport, json) {
				$(id).replace(gclms.Views.get('notebook_entry').interpolate({
					title: json.NotebookEntry.title,
					date: json.NotebookEntry.created,
					content: json.NotebookEntry.content,
					id: id
				}));
				$(id).observeRules(gclms.Triggers.get('.gclms-notebook-entry'))
			}
		});
		
		$('gclms-new-entry-title').value = '';
		$('gclms-new-entry-content').value = '';
	},
	
	getContent: function(event) {
		event.stop();
		var div = this.up('div.gclms-notebook-entry');
		var content = div.down('div.gclms-notebook-entry-content');
		content.innerHTML = '<img src="/img/permanent/spinner2007-09-14.gif"/>';
		content.displayAsBlock();

		gclms.NotebookEntry.getContent({
			id: div.id,
			callback: function(transport) {
				content.innerHTML = transport.responseText;
			}
		});
	}
}

gclms.NotebookEntry = {
	ajaxUrl: '/' + document.body.getAttribute('gclms:group') + '/' + document.body.getAttribute('gclms:course') + '/notebook/',
	add: function(options){
		var request = new Ajax.Request(this.ajaxUrl + 'add.json', {
			method: 'post',
			parameters: {
				'data[NotebookEntry][title]': options.title,
				'data[NotebookEntry][content]': options.content
			},
			onComplete: options.callback
		});
	},
	getContent: function(options) {
		var request = new Ajax.Request(this.ajaxUrl + 'content', {
			method: 'post',
			parameters: {
				'data[NotebookEntry][id]': options.id
			},
			onComplete: options.callback
		});
	}
}

gclms.Triggers.update({
	'.gclms-new-notebook-entry .gclms-button:click': gclms.NotebookController.addEntry,
	'.gclms-notebook-entry': {
		'h2 a:click': gclms.NotebookController.getContent
	}
});

gclms.Views.update({
	notebook_entry: '<div class="gclms-notebook-entry" id="#{id}"><h2><a href="#">#{title}</a> <em>#{date}</em></h2><div class="gclms-notebook-entry-content">#{content}</div></div>'
});

/*
if (!window.google || !google.gears) {
	location.href = "http://gears.google.com/?action=install&message=Test123" +
			"&return=" + location.href;
}
*/