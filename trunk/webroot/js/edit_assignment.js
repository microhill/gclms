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
			'afterLoad': function() {
				$(this.dialog).down('.gclms-nodes-tree').observeRules(gclms.Triggers.get('.gclms-nodes-tree'));
			},
			'callback': function(a) {
				$('AssignmentNodeId').value = a.getAttribute('gclms-node-id');
				$('AssignmentNodeTitle').value = a.innerHTML;
				
				return true;
			}
		});
	},
	
	toggleNodeExpansion: function() {
		var li = this.up('li');

		if(li.hasClassName('gclms-collapsed')) {
			li.removeClassName('gclms-collapsed');
			li.addClassName('gclms-expanded');
		} else if(li.hasClassName('gclms-expanded')) {
			li.addClassName('gclms-collapsed');
			li.removeClassName('gclms-expanded');
		}
	}
}

gclms.Views.update({

});

gclms.Triggers.update({
	'#AssignmentType:change': gclms.AssignmentsController.updateAssignmentTypeOptions,
	'#AssignmentHasAvailabilityDate:change': gclms.AssignmentsController.updateAvailabilityOption,
	'#AssignmentHasDueDate:change': gclms.AssignmentsController.updateDueDateOption,
	'#gclms-forum-chooser button:click': gclms.AssignmentsController.chooseForum,
	'#gclms-attached-page button:click': gclms.AssignmentsController.choosePage,
	'.gclms-nodes-tree' : {
		'li': {
			'img.gclms-expand-button:click': gclms.AssignmentsController.toggleNodeExpansion
		}
	}
});

gclms.AssignmentsController.setup();