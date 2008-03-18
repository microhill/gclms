GCLMS.DictionaryController = {
	addDictionaryTerm: function() {
		self.location = '/' + document.body.getAttribute('gclms:group') + '/' + document.body.getAttribute('gclms:course') + '/dictionary/add';
	}
}

GCLMS.Triggers.update({
	'#addDictionaryTerm:click': GCLMS.DictionaryController.addDictionaryTerm
});