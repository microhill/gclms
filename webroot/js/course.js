/* global $, $$, Ajax, Element, GCLMS, document, window, self, __ */
GCLMS.CourseController = {
	toggleNodeExpansion: function() {
		var li = this.up('li');
		
		if(li.hasClassName('gclms-collapsed')) {
			$$('#' + li.getAttribute('id') + ' > ul > li').each(function(node){
				node.displayAsBlock();
			});
			li.removeClassName('gclms-collapsed');
			li.addClassName('gclms-expanded');
		} else if(li.hasClassName('gclms-expanded')) {
			$$('#' + li.getAttribute('id') + ' > ul > li').each(function(node){
				node.hide();
			});			
			li.addClassName('gclms-collapsed');
			li.removeClassName('gclms-expanded');
		}
	}
}

GCLMS.Triggers.update({
	'#gclms-nodes-show-tree' : {
		'li': {
			'img.gclms-expand-button:click': GCLMS.CourseController.toggleNodeExpansion
		}
	}
});