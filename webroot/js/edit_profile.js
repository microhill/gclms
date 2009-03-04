gclms.ProfileController = {
	avatarPrompt: function(event) {
		event.stop();
		$('gclms-avatar-chooser').displayAsBlock();
		this.remove();
	}
}

gclms.Views.update({

});

gclms.Triggers.update({
	'#gclms-change-picture:click': gclms.ProfileController.avatarPrompt
});