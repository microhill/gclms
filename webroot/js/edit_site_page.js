//tinyMCE.init(gclms.advancedTinyMCEConfig);

gclms.Triggers.update({
	'textarea' : function() {
		tinyMCE.settings = gclms.advancedTinyMCEConfig;
		tinyMCE.execCommand('mceAddControl', false, this.id);
	}
});