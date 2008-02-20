if(document.body.getAttribute('lms:controller') == 'Courses' && (document.body.getAttribute('lms:action') == 'edit' || document.body.getAttribute('lms:action') == 'add')) {
	tinyMCE.init(GCLMS.tinyMCEConfig);

	GCLMS.Triggers.update({
		'#CourseDescription' : function() {
			tinyMCE.execCommand("mceAddControl", false, this.id);
		},
		'input.allowRedistribution:change' : function() {
			if($F(this) == '1') {
				$('extendedLicensingOptions').showAsBlock();
			} else {
				$('extendedLicensingOptions').hide();
			}
		}
	})

}