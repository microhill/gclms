GCLMS.ClassController = {
	toggleStartAndEndDate: function() {
		if($('VirtualClassHasStartAndEndDate0').checked) {
			$('gclms-start-date-div').hide();
			$('gclms-end-date-div').hide();
			$('time-limit-fieldset').displayAsBlock();
		} else {
			$('gclms-start-date-div').displayAsBlock();
			$('gclms-end-date-div').displayAsBlock();
			$('time-limit-fieldset').hide();
		}
	},
	
	toggleTimeLimit: function() {
		if($('VirtualClassHasStudentTimeLimit0').checked) {
			this.up('fieldset').select('div.input').each(function(div){
				div.hide();
			});
		} else {
			this.up('fieldset').select('div.input').each(function(div){
				div.displayAsBlock();
			});
		}
	},
	
	toggleEnrollmentDeadline: function() {
		if($('VirtualClassHasEnrollmentDeadline0').checked) {
			$('gclms-enrollment-deadline-div').hide();
		} else {
			$('gclms-enrollment-deadline-div').displayAsBlock();
		}
	}
}

GCLMS.Triggers.update({
	'#VirtualClassHasStartAndEndDate0:change,#VirtualClassHasStartAndEndDate1:change' : GCLMS.ClassController.toggleStartAndEndDate,
	'#VirtualClassHasEnrollmentDeadline0:change,#VirtualClassHasEnrollmentDeadline1:change' : GCLMS.ClassController.toggleEnrollmentDeadline,
	'#VirtualClassHasStudentTimeLimit0:change,#VirtualClassHasStudentTimeLimit1:change' : GCLMS.ClassController.toggleTimeLimit
});