gclms.NotebookController = {
	addEntry: function(event) {
		event.stop();
		
		if($F('gclms-new-entry-content').empty()) {
			alert('Cannot be empty.');
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
					content: json.NotebookEntry.content,
					id: id
				}));

			}
		});
		
		$('gclms-new-entry-title').value = '';
		$('gclms-new-entry-content').value = '';
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
	}
}

gclms.Triggers.update({
	'.gclms-new-notebook-entry .gclms-button:click': gclms.NotebookController.addEntry
});

gclms.Views.update({
	notebook_entry: '<div class="gclms-notebook-entry" id="#{id}"><h2>#{title}</h2>#{content}</div>'
});