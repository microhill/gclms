gclms.ArticleController = {
	addArticle: function() {
		self.location = 'articles/add';
	}
}

gclms.Triggers.update({
	'#addArticle:click': gclms.ArticleController.addArticle,
	'.gclms-framed ul.articles a:click,.gclms-framed .gclms-step-back a:click': gclms.AppController.gotoFramedLink
});