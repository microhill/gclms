tinyMCE.init(gclms.advancedTinyMCEConfig);

gclms.CourseController = {
	loadLanguageDetector: function() {

	},
	detectLanguage: function() {
		google.language.detect($F('CourseTitle'),
		function(result) {
			if(result.confidence > 0.20 && $$('#CourseLanguage option[value="' + result.language + '"]').length) {
				$('CourseLanguage').value = result.language;
			}
		});
	}
}

gclms.Triggers.update({
	'#CourseDescription' : function() {
		tinyMCE.execCommand('mceAddControl', false, this.id);
	},
	'input.allowRedistribution:change' : function() {
		if($F(this) == '1') {
			$('extendedLicensingOptions').displayAsBlock();
		} else {
			$('extendedLicensingOptions').hide();
		}
	},
	'div.gclms-add-course': gclms.CourseController.loadLanguageDetector,
	'div.gclms-add-course #CourseTitle:change': gclms.CourseController.detectLanguage,
	'form .gclms-button.gclms-submit a:click': gclms.AppController.submitForm
});
