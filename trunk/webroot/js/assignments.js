gclms.AssignmentsController = {
	setup: function() {
	},
	
	confirmDeleteAssignments: function(event) {
		event.stop();
		if(!$$('input.gclms-assignment-select:checked').length) {
			return false;
		}
		var popup = new gclms.confirm({
			text: 'Are you sure?',
			callback: gclms.AssignmentsController.deleteAssignments.bind(this)
		});
	},
	
	deleteAssignments: function() {
		var form = this.up('form');
		form.setAttribute('action',form.getAttribute('action') + 'delete')
		form.submit();
	},
	
	selectAll: function () {
		if(this.checked) {
			$$('input.gclms-assignment-select').each(function(input) { //:not(:checked)
				input.checked = true;
				input.up('tr').addClassName('gclms-selected');
			});		
		} else {
			$$('input.gclms-assignment-select:checked').each(function(input) {
				input.checked = false;				
				input.up('tr').removeClassName('gclms-selected');
			});		
		}

	},
	
	updateSelectAllCheckbox: function () {
		if(!$$('input.gclms-assignment-select').length) {
			//$('gclms-assignments').hide();
			$('gclms-select-all').checked = false;
		} else if ($$('input.gclms-assignment-select:not(:checked)').length) {
			$('gclms-select-all').checked = false;
		} else {
			$('gclms-select-all').checked = true;			
		}
	},
	
	updateAssignmentSelection: function(event) {
		gclms.AssignmentsController.updateSelectAllCheckbox();
		gclms.AssignmentsController.updateAssignmentRowClass.bind(this)();
	},
	
	updateAssignmentRowClass: function(event){
		if (this.checked) {
			this.up('tr').addClassName('gclms-selected');
		}
		else {
			this.up('tr').removeClassName('gclms-selected');
		}
	}
}

gclms.Triggers.update({
	'button.gclms-delete-assignments:click': gclms.AssignmentsController.confirmDeleteAssignments,
	'#gclms-select-all:click': gclms.AssignmentsController.selectAll,
	'input.gclms-assignment-select': {
		':loaded': gclms.AssignmentsController.updateAssignmentRowClass,
		':change': gclms.AssignmentsController.updateAssignmentSelection
	}
});

gclms.AssignmentsController.setup();