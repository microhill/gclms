tinyMCE.init(GCLMS.advancedTinyMCEConfig);

GCLMS.Triggers.update({
	'textarea#GroupDescription' : function() {
		tinyMCE.execCommand("mceAddControl", false, this.id);
	},
	'#gclms-clear-group-logo:click' : function(event) {
		event.stop();
		this.hide();
		$('GroupLogo').displayAsInline();
		$('gclms-page').select('form').first().insert({top:
				new Element('input',{
					name: 'data[Group][clear_logo]',
					type: 'hidden',
					value: 1
				}
			)}
		);
	}
});