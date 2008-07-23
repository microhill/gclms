GCLMS.ArticleController = {
	addArticle: function() {
		self.location = 'articles/add';
	},
	
	gotoFramedArticle: function(event) {
		event.stop();
		location.href = this.getAttribute('href') + '?framed';
	}
}

GCLMS.Triggers.update({
	'#addArticle:click': GCLMS.ArticleController.addArticle,
	'.gclms-framed ul.articles a:click,.gclms-framed .gclms-step-back a:click': GCLMS.ArticleController.gotoFramedArticle
});