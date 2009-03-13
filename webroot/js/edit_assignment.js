gclms.AssignmentsController = {
	setup: function() {
		//gclms.AssignmentsController.updateAssignmentTypeOptions();
		//gclms.AssignmentsController.updateAvailabilityOption();
		gclms.AssignmentsController.updateDueDateOption();
		
		gclms.Views.update({
			pageObject: pageObjectView,
			forumObject: forumObjectView
		});
	},
	
	updateAssignmentTypeOptions: function() {
		if($F('AssignmentType') == 'quiz') {
			$('gclms-quiz-availability-date').displayAsBlock();
			$('gclms-time-limit-chooser').displayAsBlock();
			$('gclms-reminder-page').displayAsBlock();
			$('gclms-forum-chooser').hide();
		} else {
			if($F('AssignmentType') == 'forum') {
				$('gclms-forum-chooser').displayAsBlock();
			} else {
				$('gclms-forum-chooser').hide();
			}
			$('gclms-quiz-availability-date').hide();
			$('gclms-time-limit-chooser').hide();
			$('gclms-reminder-page').displayAsBlock();
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
	
	chooseReminderPage: function(event) {
		event.stop();
		
		var selector = new gclms.selector({
			'url': gclms.urlPrefix + 'content/select',
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
	
	addAssociatedObject: function(event) {
		event.stop();

		var type = $F('AssignmentAssociatedObjectType');
		if($F('AssignmentAssociatedObjectType') == 'Page') {
			gclms.AssignmentsController.addPageObject();
		} else if($F('AssignmentAssociatedObjectType') == 'Forum') {
			gclms.AssignmentsController.addForumObject();
		}
	},
	
	addPageObject: function() {
		var selector = new gclms.selector({
			'url': gclms.urlPrefix + 'content/select',
			'afterLoad': function() {
				$(this.dialog).down('.gclms-nodes-tree').observeRules(gclms.Triggers.get('.gclms-nodes-tree'));
			},
			'callback': function(a) {
				var page = $('gclms-associated-objects').insert(gclms.Views.get('pageObject').interpolate({
					id: UUID.generate(),
					model: 'page',
					foreign_key: a.getAttribute('gclms-node-id'),
					title: a.innerHTML
				}));
				page.observeRules(gclms.Triggers.get('.gclms-assignment-association'));
				
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
	},
	
	addForumObject: function() {		
		var selector = new gclms.selector({
			'url': gclms.urlPrefix + 'forums/select',
			'callback': function(a) {
				var forum = $('gclms-associated-objects').insert(gclms.Views.get('forumObject').interpolate({
					id: UUID.generate(),
					model: 'forum',
					foreign_key: a.getAttribute('gclms-forum-id'),
					title: a.innerHTML
				}));
				
				forum.observeRules(gclms.Triggers.get('.gclms-assignment-association'));
				
				return true;
			}
		});
	},
	
	changeFigureResultsIntoGrade: function() {
		var row = this.up('table').down('tr.gclms-percentage-of-grade');
		if(this.checked) {
			row.displayAsTableRow();
		} else {
			row.hide();			
		}
	},
	
	deleteAssociation: function(event) {
		event.stop();
		
		var confirm = new gclms.confirm({
			text: __('Are you sure you want to delete this?'),
			confirmButtonText: __('Yes'),
			cancelButtonText: __('No'),
			callback: function() {
				this.up('.gclms-assignment-association').remove();
			}.bind(this)
		});
	}
}

gclms.Triggers.update({
	//'#AssignmentType:change': gclms.AssignmentsController.updateAssignmentTypeOptions,
	//'#AssignmentHasAvailabilityDate:change': gclms.AssignmentsController.updateAvailabilityOption,
	'#AssignmentHasDueDate:change': gclms.AssignmentsController.updateDueDateOption,
	//'#gclms-forum-chooser button:click': gclms.AssignmentsController.chooseForum,
	'#gclms-reminder-page button:click': gclms.AssignmentsController.chooseReminderPage,
	'.gclms-nodes-tree' : {
		'li': {
			'img.gclms-expand-button:click': gclms.AssignmentsController.toggleNodeExpansion
		}
	},
	'#gclms-add-associated-object button.gclms-add:click': gclms.AssignmentsController.addAssociatedObject,
	'.gclms-assignment-association': {
		'.gclms-figured-into-grade:change': gclms.AssignmentsController.changeFigureResultsIntoGrade,
		'.gclms-delete:click': gclms.AssignmentsController.deleteAssociation
	}
});

gclms.AssignmentsController.setup();