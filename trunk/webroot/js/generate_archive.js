  GCLMS.GenerateArchiveController = {
	progress: function() {
		location.replace($('gclms-progress').getAttribute('gclms:next-href')); 
	}
}

GCLMS.Triggers.update({
	'#gclms-progress' : GCLMS.GenerateArchiveController.progress
});