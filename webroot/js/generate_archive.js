GCLMS.GenerateArchiveController = {
	progress: function() {
		self.location = $('gclms-progress').getAttribute('gclms:next-href');
	}
}

GCLMS.Triggers.update({
	'#gclms-progress' : GCLMS.GenerateArchiveController.progress
});