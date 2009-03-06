gclms.ProfileController = {
	avatarPrompt: function(event) {
		event.stop();
		$('gclms-avatar-chooser').displayAsBlock();
		this.remove();
	},
	
	selectUploadAvatar: function() {
		$('UserAvatarUpload').checked = true;
	}
}

gclms.Views.update({

});

gclms.Triggers.update({
	'#gclms-change-picture:click': gclms.ProfileController.avatarPrompt,
	'#UserAvatarFile:change': gclms.ProfileController.selectUploadAvatar
});