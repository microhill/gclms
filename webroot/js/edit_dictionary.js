tinyMCE.init(GCLMS.tinyMCEConfig);

GCLMS.DictionaryController = {
	loadTinyMCE: function() {
		tinyMCE.execCommand("mceAddControl", false, this.id);
	}
}

GCLMS.Triggers.update({
	'textarea': GCLMS.DictionaryController.loadTinyMCE
});