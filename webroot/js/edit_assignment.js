gclms.AssignmentsController = {
	setup: function() {
		gclms.AssignmentsController.updateAssignmentTypeOptions();
		gclms.AssignmentsController.updateAvailabilityOption();
		gclms.AssignmentsController.updateDueDateOption();
	},
	
	updateAssignmentTypeOptions: function() {
		if($F('AssignmentType') == 'quiz') {
			$('gclms-quiz-availability-date').displayAsBlock();
			$('gclms-time-limit-chooser').displayAsBlock();
			$('gclms-attached-page').displayAsBlock();
			$('gclms-forum-chooser').hide();
		} else {
			if($F('AssignmentType') == 'forum') {
				$('gclms-forum-chooser').displayAsBlock();
			} else {
				$('gclms-forum-chooser').hide();
			}
			$('gclms-quiz-availability-date').hide();
			$('gclms-time-limit-chooser').hide();
			$('gclms-attached-page').displayAsBlock();
		}
	},
	
	updateAvailabilityOption: function() {
		if($F('AssignmentHasAvailabilityDate')) {
			$('AssignmentAvailabilityDateWeek').removeAttribute('disabled');
			$('AssignmentAvailabilityDateDay').removeAttribute('disabled');
		} else {
			$('AssignmentAvailabilityDateWeek').setAttribute('disabled','disabled');
			$('AssignmentAvailabilityDateDay').setAttribute('disabled','disabled');
		}
	},
	
	updateDueDateOption: function() {
		if($F('AssignmentHasDueDate')) {
			$('AssignmentDueDateWeek').removeAttribute('disabled');
			$('AssignmentDueDateDay').removeAttribute('disabled');
		} else {
			$('AssignmentDueDateWeek').setAttribute('disabled','disabled');
			$('AssignmentDueDateDay').setAttribute('disabled','disabled');
		}
	},
	
	chooseForum: function(event) {
		event.stop();
		
		var selector = new gclms.selector({
			'url': '../forums/list_for_popup',
			'callback': function(a) {
				$('AssignmentForumId').value = a.getAttribute('gclms-forum-id');
				$('AssignmentForumTitle').value = a.innerHTML;
			}
		});
	},
	
	choosePage: function(event) {
		event.stop();
		
		var selector = new gclms.selector({
			'url': '../../content/select',
			'width': 500,
			'height': 400,
			'callback': function(a) {
				$('AssignmentForumId').value = a.getAttribute('gclms-forum-id');
				$('AssignmentForumTitle').value = a.innerHTML;
			}
		});
	}
}

gclms.Views.update({

});

gclms.Triggers.update({
	'#AssignmentType:change': gclms.AssignmentsController.updateAssignmentTypeOptions,
	'#AssignmentHasAvailabilityDate:change': gclms.AssignmentsController.updateAvailabilityOption,
	'#AssignmentHasDueDate:change': gclms.AssignmentsController.updateDueDateOption,
	'#gclms-forum-chooser button:click': gclms.AssignmentsController.chooseForum,
	'#gclms-attached-page button:click': gclms.AssignmentsController.choosePage
});

gclms.AssignmentsController.setup();