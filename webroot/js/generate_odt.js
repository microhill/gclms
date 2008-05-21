GCLMS.GenerateOdtController = {
	progress: function() {
		location.replace($('gclms-progress').getAttribute('gclms:next-href'));
	}
}

GCLMS.Triggers.update({
	'#gclms-progress' : GCLMS.GenerateOdtController.progress
});