tinyMCE.init(GCLMS.tinyMCEConfig);

GCLMS.Triggers.update({
	'textarea' : function() {
		tinyMCE.execCommand("mceAddControl", false, this.id);
	}
});