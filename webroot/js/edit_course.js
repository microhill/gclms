GCLMS.Triggers.update({
	'#CourseDescription' : function() {
		tinyMCE.init(GCLMS.tinyMCEConfig);
		tinyMCE.execCommand("mceAddControl", false, this.id);
	},
	'input.allowRedistribution:change' : function() {
		if($F(this) == '1') {
			$('extendedLicensingOptions').displayAsBlock();
		} else {
			$('extendedLicensingOptions').hide();
		}
	}
});