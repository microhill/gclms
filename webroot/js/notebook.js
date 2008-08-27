gclms.NotebookController = {
	addEntry: function(event) {
		gclms.NotebookEntry.add({
			title: $F('gclms-new-entry-title'),
			content: $F('gclms-new-entry-content'),
			callback: function(transport, json) {
				window.location.reload();
			}
		});
		event.stop();
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