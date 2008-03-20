GCLMS.GlossaryController = {
	addGlossaryTerm: function() {
		self.location = '/' + document.body.getAttribute('gclms:group') + '/' + document.body.getAttribute('gclms:course') + '/glossary/add';
	}
}

GCLMS.Triggers.update({
	'#addGlossaryTerm:click': GCLMS.GlossaryController.addGlossaryTerm
});