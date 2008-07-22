GCLMS.GlossaryController = {
	addGlossaryTerm: function() {
		self.location = 'glossary/add';
	},
	
	gotoFramedGlossaryTerm: function(event) {
		event.stop();
		location.href = this.getAttribute('href') + '?framed';
	}
}

GCLMS.Triggers.update({
	'#addGlossaryTerm:click': GCLMS.GlossaryController.addGlossaryTerm,
	'.gclms-framed ul.glossary a:click': GCLMS.GlossaryController.gotoFramedGlossaryTerm
});