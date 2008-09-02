gclms.notebookTinyMCEConfig = {
	theme : 'advanced',
	extended_valid_elements : 'a[name|href|target|title],em',
	theme_advanced_buttons1 : '',
	convert_urls: false,
	tab_focus : ':next',
	cleanup_serializer: 'xml',
	gecko_spellcheck: true,
	mode: "none",
	theme_advanced_toolbar_location : 'top',
	theme_advanced_toolbar_align : 'left',
	theme_advanced_buttons1 : 'italic,bold,bullist,numlist,removeformat',
	theme_advanced_buttons2 : '',
	file_browser_callback : 'gclms.fileBrowser',
	width: '100%',
	height: '200px',
    language: document.body.getAttribute('gclms:language'),
	cleanup_serializer: 'xml',
	button_tile_map: true,
	theme_advanced_blockformats : '',
	skin: 'gclms',
	extended_valid_elements : 'a[name|href|target|title],em,i,ol,ul,li,u'
};

gclms.NotebookController = {
	enableTinyMCE: function() {
		tinyMCE.settings = gclms.notebookTinyMCEConfig;
		tinyMCE.execCommand('mceAddControl', false, this.id);
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
	'div.gclms-framed': {
		'a:click': gclms.AppController.updateLink
	},
	'form .gclms-button a:click': gclms.AppController.submitForm,
	'textarea#gclms-new-entry-content': gclms.NotebookController.enableTinyMCE
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