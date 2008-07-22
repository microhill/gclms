GCLMS.ArticleController = {
	addArticle: function() {
		self.location = '/' + document.body.getAttribute('gclms:group') + '/' + document.body.getAttribute('gclms:course') + '/articles/add';
	},
	
	gotoFramedArticle: function() {
		location.href = this.getAttribute('href') + '?framed';
	}
}

GCLMS.Triggers.update({
	'#addArticle:click': GCLMS.ArticleController.addArticle,
	'.gclms-framed ul.glossary a:click': GCLMS.GlossaryController.gotoFramedGlossaryTerm
});