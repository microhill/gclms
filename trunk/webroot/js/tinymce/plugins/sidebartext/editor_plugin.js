/**
 * $Id: editor_plugin_src.js 42 2006-08-08 14:32:24Z spocke $
 *
 * @author Moxiecode
 * @copyright Copyright © 2004-2007, Moxiecode Systems AB, All rights reserved.
 */

/* Import plugin specific language pack */
tinyMCE.importPluginLanguagePack('sidebartext');

var TinyMCE_SidebarTextPlugin = {
	getInfo : function() {
		return {
			longname : 'Sidebar Text',
			author : 'Aaron Shafovaloff',
			authorurl : 'http://www.aaronshaf.com',
			infourl : 'http://www.gclms.com',
			version : '1.0'
		};
	},

	getControlHTML : function(cn) {
		switch (cn) {
			case "sidebartext":
				return tinyMCE.getButtonHTML(cn, 'lang_sidebartext_desc', '{$pluginurl}/images/sidebartext.gif', 'mceSidebarText', false);
		}

		return "";
	},


	execCommand : function(editor_id, element, command, user_interface, value) {
		var inst = tinyMCE.getInstanceById(editor_id), h;

		switch (command) {
			case "mceSidebarText":
		        var selectedHtml = inst.selection.getSelectedHTML();
				h = '[SidebarText]' + selectedHtml + '[/SidebarText]';
				tinyMCE.execInstanceCommand(editor_id, 'mceReplaceContent', false, h);
				return true;
		}

		return false;
	},

	handleEvent : function(e) {
		var inst, h;

		return true;
	}
};

tinyMCE.addPlugin("sidebartext", TinyMCE_SidebarTextPlugin);