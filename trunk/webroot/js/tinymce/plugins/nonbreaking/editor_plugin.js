/**
 * $Id: editor_plugin_src.js 42 2006-08-08 14:32:24Z spocke $
 *
 * @author Moxiecode
 * @copyright Copyright © 2004-2007, Moxiecode Systems AB, All rights reserved.
 */

/* Import plugin specific language pack */
tinyMCE.importPluginLanguagePack('notebook');

var TinyMCE_NotebookPlugin = {
	getInfo : function() {
		return {
			longname : 'Notebook',
			author : 'Aaron Shafovaloff',
			authorurl : 'http://www.aaronshaf.com',
			infourl : 'http://www.gclms.com',
			version : '1.0'
		};
	},

	getControlHTML : function(cn) {
		switch (cn) {
			case "notebook":
				return tinyMCE.getButtonHTML(cn, 'lang_notebook_desc', '{$pluginurl}/images/notebook.gif', 'mceNotebook', false);
		}

		return "";
	},


	execCommand : function(editor_id, element, command, user_interface, value) {
		var inst = tinyMCE.getInstanceById(editor_id), h;

		switch (command) {
			case "mceNotebook":
				h = '<img src="/img/notebook-32.png" name="mce_notebook" class="gclms-notebook" />';
				tinyMCE.execInstanceCommand(editor_id, 'mceInsertContent', false, h);
				return true;
		}

		return false;
	},

	handleEvent : function(e) {
		var inst, h;

		return true;
	}
};

tinyMCE.addPlugin("notebook", TinyMCE_NotebookPlugin);