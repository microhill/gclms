GCLMS.ArticleController = {
	addArticle: function() {
		self.location = 'articles/add';
	}
}

GCLMS.Triggers.update({
	'#addArticle:click': GCLMS.ArticleController.addArticle,
	'.gclms-framed ul.articles a:click,.gclms-framed .gclms-step-back a:click': GCLMS.AppController.gotoFramedLink
});