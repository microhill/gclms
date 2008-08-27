gclms.GenerateOdtController = {
	progress: function() {
		location.replace($('gclms-progress').getAttribute('gclms:next-href'));
	}
}

gclms.Triggers.update({
	'#gclms-progress' : gclms.GenerateOdtController.progress
});