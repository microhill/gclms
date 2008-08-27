tinyMCE.init(gclms.advancedTinyMCEConfig);

gclms.Triggers.update({
	'textarea' : function() {
		tinyMCE.execCommand("mceAddControl", false, this.id);
	}
});