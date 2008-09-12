gclms.GlossaryController = {
	addGlossaryTerm: function() {
		self.location = 'glossary/add';
	}
}

gclms.Triggers.update({
	'#addGlossaryTerm:click': gclms.GlossaryController.addGlossaryTerm,
	'.gclms-framed ul.glossary a:click,.gclms-framed .gclms-step-back a:click': gclms.AppController.gotoLink
});