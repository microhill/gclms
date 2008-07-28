GCLMS.GlossaryController = {
	addGlossaryTerm: function() {
		self.location = 'glossary/add';
	}
}

GCLMS.Triggers.update({
	'#addGlossaryTerm:click': GCLMS.GlossaryController.addGlossaryTerm,
	'.gclms-framed ul.glossary a:click,.gclms-framed .gclms-step-back a:click': GCLMS.AppController.gotoFramedLink
});