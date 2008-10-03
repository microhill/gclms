gclms.PermissionsController = {
	changeUser: function(event) {
		event.stop();
		/*
		var test = new gclms.prompt({
			text: 'Select user (by username or e-mail)'
		});
		*/
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
			course_permissions: tmpCoursePermissionsView
		});
	},
	
	addCourse: function(event) {
		event.stop();
		var id = $F('gclms-unselected-courses');
		var option = $('gclms-course-selection').down('option[value="' + id + '"]');
		option.remove();
		var course_permissions = $('gclms-courses').insert({top: gclms.Views.get('course_permissions').interpolate({
			course_title: option.innerHTML,
			course_id: id
		})});
		course_permissions.observeRules(gclms.Triggers.get('.gclms-course-permissions'));
		
		if(!$('gclms-unselected-courses').select('option').length) {
			$('gclms-course-selection').remove();
		}
	},
	
	toggleClassCreationPermission: function(event) {
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
	':loaded': gclms.PermissionsController.loadViews,
	'#gclms-change-user:click': gclms.PermissionsController.changeUser,
	'#gclms-cancel-change-user:click': gclms.PermissionsController.cancelChangeUser,
	'#gclms-add-course:click': gclms.PermissionsController.addCourse,
	'.gclms-course-permissions': {
		'.gclms-add-class-for-approval:change,.gclms-add-class-without-approval:change': gclms.PermissionsController.toggleClassCreationPermission
	}
});

gclms.User = {
	search: function(options) {
		
	}
}
