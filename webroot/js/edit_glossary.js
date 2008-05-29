tinyMCE.init(GCLMS.advancedTinyMCEConfig);

GCLMS.GlossaryController = {
	loadTinyMCE: function() {
		tinyMCE.execCommand("mceAddControl", false, this.id);
	}
}

GCLMS.Triggers.update({
	'textarea': GCLMS.GlossaryController.loadTinyMCE
});