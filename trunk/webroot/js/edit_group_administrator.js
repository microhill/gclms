gclms.Triggers.update({
	'form .gclms-button.gclms-submit a:click': gclms.AppController.submitForm,
	'#GroupAdministratorAddForm #GroupAdministratorEmail:keyup, #GroupAdministratorAddForm #GroupAdministratorEmail:change' : function(event) {
		$('GroupAdministratorEmail').removeAttribute('readonly');
		if($F(this) < 2 || event.keyCode < 32 || (event.keyCode >= 33 && event.keyCode <= 46) || (event.keyCode >= 112 && event.keyCode <= 123))
			return false;

		request = new Ajax.Request('/administration/users/dropdown/' + $F(this), {
			onComplete:function(request){
				text = request.responseText.stripTags();
				if(text.empty())
					return false;
				$('GroupAdministratorEmail').value = text;
				$('GroupAdministratorGroupId').focus();
				$('GroupAdministratorEmail').setAttribute('readonly','readonly');
			}
		})
	}
});