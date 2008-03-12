GCLMS.DictionaryController = {
	addDictionaryTerm: function() {
		self.location = '/' + document.body.getAttribute('lms:group') + '/' + document.body.getAttribute('lms:course') + '/dictionary/add';
	}
}

GCLMS.Triggers.update({
	'#addDictionaryTerm:click': GCLMS.DictionaryController.addDictionaryTerm
});