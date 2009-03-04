gclms.GradebokController = {
	prepareGradeEdit: function() {
		var input = new Element('input',{
			value: this.getAttribute('gclms-grade-value')
		});
		input.setStyle({
			//width: this.getWidth() + 'px'
		});
		this.update(input);

		input.focus();
		input.select();
	}
}

gclms.Triggers.update({
	'.gclms-grade:click': gclms.GradebokController.prepareGradeEdit
});