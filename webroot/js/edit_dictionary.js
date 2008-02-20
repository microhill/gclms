if(document.body.getAttribute('lms:controller') == 'Dictionary' && document.body.getAttribute('lms:action') != 'index') {
	tinyMCE.init(GCLMS.tinyMCEConfig);

	GCLMS.Triggers.update({
		'textarea' : function() {
			tinyMCE.execCommand("mceAddControl", false, this.id);
		}
	});
}