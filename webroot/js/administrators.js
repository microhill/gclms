gclms.AdministratorsController = {
	changeUser: function(event) {
		$('gclms-user').hide();
		$('gclms-user-permissions').hide();
		$('gclms-user-search').displayAsBlock();
		$('UserSearchName').focus();
		$('gclms-save-button').up('div').hide();
		$('gclms-cancel-change-user').removeClassName('gclms-hidden');
	},
	
	cancelChangeUser: function() {
		$('gclms-user').displayAsBlock();
		$('gclms-user-permissions').displayAsBlock();
		$('gclms-user-search').hide();
		$('gclms-save-button').up('div').display();
	},
	
	loadViews: function() {
		gclms.Views.update({
			group_administrator: tmpGroupAdministratorView
		});
	},
	
	addGroup: function(event) {
		event.stop();
		var id = $F('gclms-unselected-groups');
		var option = $('gclms-group-selection').down('option[value="' + id + '"]');
		option.remove();
		var group_permissions = $('gclms-groups').insert({top: gclms.Views.get('group_administrator').interpolate({
			group_title: option.innerHTML,
			group_id: id
		})});
		group_permissions.observeRules(gclms.Triggers.get('.gclms-group-permissions'));
		
		if(!$('gclms-unselected-groups').select('option').length) {
			$('gclms-group-selection').remove();
		}
	},
	
	toggleClassCreationAdministrator: function(event) {
		var fieldset = this.up('fieldset');	
		var forApproval = fieldset.down('.gclms-add-class-for-approval');
		var withoutApproval = fieldset.down('.gclms-add-class-without-approval');
		
		if(this == forApproval) {
			if($F(this)) {
				withoutApproval.checked = false;
			} else {
				forApproval.checked = false;
			}
		} else {
			if($F(this)) {
				forApproval.checked = false;
			} else {
				withoutApproval.checked = false;
			}
		}
	}
}

gclms.Triggers.update({
	':loaded': gclms.AdministratorsController.loadViews,
	'#gclms-change-user:click': gclms.AdministratorsController.changeUser,
	'#gclms-cancel-change-user:click': gclms.AdministratorsController.cancelChangeUser,
	'#gclms-add-group:click': gclms.AdministratorsController.addGroup,
	'.gclms-group-permissions': {
		'.gclms-add-class-for-approval:change,.gclms-add-class-without-approval:change': gclms.AdministratorsController.toggleClassCreationAdministrator
	}
});

gclms.User = {
	search: function(options) {
		
	}
}
