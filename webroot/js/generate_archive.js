gclms.GenerateArchiveController = {
	progress: function() {
		location.replace($('gclms-progress').getAttribute('gclms:next-href')); 
	}
}

gclms.Triggers.update({
	'#gclms-progress' : gclms.GenerateArchiveController.progress
});