tinyMCE.init(gclms.advancedTinyMCEConfig);

gclms.GlossaryController = {
	loadTinyMCE: function() {
		tinyMCE.execCommand("mceAddControl", false, this.id);
	}
}

gclms.Triggers.update({
	'textarea': gclms.GlossaryController.loadTinyMCE
});