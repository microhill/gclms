tinyMCE.init(GCLMS.advancedTinyMCEConfig);

GCLMS.Triggers.update({
	'textarea' : function() {
		tinyMCE.execCommand("mceAddControl", false, this.id);
	}
});