GCLMS.ArticleController = {
	addArticle: function() {
		self.location = '/' + document.body.getAttribute('lms:group') + '/' + document.body.getAttribute('lms:course') + '/articles/add';
	}
}

GCLMS.Triggers.update({
	'#addArticle:click': GCLMS.ArticleController.addArticle
});