GCLMS.Triggers.update({
	'#GroupAdministratorAddForm #GroupAdministratorUsername:keyup, #GroupAdministratorAddForm #GroupAdministratorUsername:change' : function(event) {
		$('GroupAdministratorUsername').removeAttribute('readonly');
		if($F(this) < 2 || event.keyCode < 32 || (event.keyCode >= 33 && event.keyCode <= 46) || (event.keyCode >= 112 && event.keyCode <= 123))
			return false;
		
		new Ajax.Request('/administration/users/dropdown/' + $F(this), {
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