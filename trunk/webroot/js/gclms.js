/*global $, $$, Ajax, Element, GCLMS, Sortable, document, window, self, UUID, $F, $H, __, Event, tinyMCE */

var gclms = {};

function __(text){
    try {
        if(gclms.translated_phrases[text]) {
			return gclms.translated_phrases[text];	
		}
    } catch (e) {}
	return text;
}

gclms.translated_phrases = [];

gclms.AppController = {
	updateLink: function(event) {
		var href = this.getAttribute('href');
		if(href.include('?framed')) {
			return true;
		}
		if(href.include('#')) {
			href = this.getAttribute('href').split('#');
			href = href[0] + '?framed#' + href[1];	
		} else {
			href += '?framed';
		}
		this.setAttribute('href',href);
	},

	confirmRemove: function(event) {
		event.stop();
		gclms.popup.create({
			text: this.getAttribute('gclms:confirm-text'),
			confirmButtonText: __('Yes'),
			cancelButtonText: __('No'),
			type: 'confirm',
			callback: gclms.AppController.remove.bind(this)
		});
	},
	remove: function() {
		location.href = this.getAttribute('href');
		/*
		var form = this.up('form');
		if(form.getAttribute('gclms:deleteAction')) {
			self.location.href = form.getAttribute('gclms:deleteAction');
		} else {
			var action = this.up('form').getAttribute('action').split('/edit/');
			self.location.href = action[0] + '/delete/' + action[1];
		}
		*/
	},
	showTooltip: function() {
		if(!gclms.tooltip) {
			gclms.tooltip = new Element('div', {
				id: 'gclms-tooltip'
			});			
			gclms.tooltip.appendChild(
				new Element('div',{
					id: 'gclms-tooltip-content'
				})
			);
			document.body.appendChild(gclms.tooltip);		
		}
		$('gclms-tooltip-content').update(this.getAttribute('tooltip:text'));	
		$('gclms-tooltip').displayAsBlock();
		$('gclms-tooltip').setStyle({
			left: (this.cumulativeOffset()[0] + this.getWidth()) + 'px',
			top: (this.cumulativeOffset()[1] - gclms.tooltip.getHeight()) + 'px'
		});
	},
	hideTooltip: function() {
		$('gclms-tooltip').hide();
	},
	createPopup: function(options) {
		options = $H({
			modal: false,
			type: 'prompt',
			value: '',
			confirmButtonText: 'OK',
			cancelButtonText: 'Cancel',
			callback: null,
			cancelCallback: null
		}).update(options);
	
		gclms.popup.callback = options.get('callback');
		gclms.popup.cancelCallback = options.get('cancelCallback');
			
		if(!gclms.popup.overlay) {
			gclms.popup.overlay = new Element('div',{
				className: 'gclms-popup-overlay'
			});
			gclms.popup.overlay.observe('click',function(event) {
				gclms.popup.overlay.hide();
			});
		}
		gclms.popup.overlay.style.display = 'block';
		
		gclms.popup.dialog = new Element('div',{
			className: 'gclms-popup-dialog'
		});
		document.body.insert(gclms.popup.overlay);
	
		gclms.popup.dialog.insert(new Element('p').insert(options.get('text')));
	
		if(options.get('type') == 'prompt'){
			gclms.popup.dialog.insert(new Element('p').insert(new Element('input',{
				type: 'text',
				id: 'gclmsPopupDialogInputText',
				value: options.get('value')
			})));
			gclms.popup.dialog.select('input[type="text"]').first().observe('keydown',function(event){
				if(event.keyCode == Event.KEY_ESC) {
					this.up('div.gclms-popup-overlay').hide();	
					if(gclms.popup.cancelCallback) {
						gclms.popup.cancelCallback();
					}
				}
				if(event.keyCode == Event.KEY_RETURN) {
					this.up('div.gclms-popup-overlay').hide();
					if(gclms.popup.callback) {
						gclms.popup.callback(gclms.popup.dialog.select('input[type="text"]').first().value);
					}
				}
			});
			
			gclms.popup.getCallbackValue = function() {
				return gclms.popup.dialog.select('input[type="text"]').first().value;
			};
		} else if(options.get('type') == 'confirm'){
			gclms.popup.getCallbackValue = function() {
				return true;
			};			
		}
		
		var div = new Element('div');
		div.appendChild(new Element('button',{
			className: 'gclms-ok',
			id: 'gclmsPopupDialogOkButton'
		})).insert(options.get('confirmButtonText'));
	
		div.select('button.gclms-ok').first().observe('click',function(event){
			gclms.AppController.closePopup({executeCallback: true});
		});
		
		if(options.get('type') == 'confirm') {
			gclms.popup.keyDownHandler = function(event) {
				if (event.keyCode == 89) {
					gclms.AppController.closePopup({executeCallback: true});
				} else if (event.keyCode == 78) {
					gclms.AppController.closePopup({executeCallback: false});
				}
			};
			document.observe('keydown',gclms.popup.keyDownHandler);
		}
		
		if(options.get('cancelButtonText') !== null) {
			div.appendChild(new Element('button',{
				className: 'gclms-cancel',
				id: 'gclms-popup-dialog-cancel-button'
			})).insert(options.get('cancelButtonText'));
			
			div.select('button.gclms-cancel').first().observe('click',function(event){
				gclms.AppController.closePopup({executeCallback: false});
			});
		}
	
		gclms.popup.dialog.insert(div);
		
		gclms.popup.dialog.observe('click',function(event){
			event.stop();
		});
		
		gclms.popup.overlay.select('.gclms-popup-dialog').each(function(div){
			div.remove();
		});
		gclms.popup.overlay.insert(gclms.popup.dialog);
		if(gclms.popup.dialog.select('input[type="text"]').first()) {
			gclms.popup.dialog.select('input[type="text"]').first().focus();
			gclms.popup.dialog.select('input[type="text"]').first().select();
		}
		
		// Vertically center the dialog
		gclms.popup.dialog.setStyle({marginTop: (gclms.popup.overlay.offsetHeight / 2) -  (gclms.popup.dialog.offsetHeight / 2) + 'px'});
	},
	closePopup: function(options) {
		$$('div.gclms-popup-overlay').first().hide();
		gclms.popup.dialog.remove();
		document.stopObserving('keydown',gclms.popup.keyDownHandler);
		if (options.executeCallback && gclms.popup.callback) {
			gclms.popup.callback(gclms.popup.getCallbackValue());
		} else if (gclms.popup.cancelCallback) {
			gclms.popup.cancelCallback();
		}
	},
	updateLoginPanel: function(event) {
		//alert(event.keyCode)
		if($F(this).indexOf('@') != -1) {
			$('UserPasswordDiv').displayAsBlock();
		} else {
			//$('UserPasswordDiv').hide();
		}
		
		if($F('UserEmail').strip().indexOf('http:') === 0) {
			if(!$('UserEmail').hasClassName('gclms-openid')) {
				$('UserEmail').addClassName('gclms-openid');
			}
		} else {
			if($('UserEmail').hasClassName('gclms-openid')) {
				$('UserEmail').removeClassName('gclms-openid');				
			}
		}
	},
	submitForm: function(event) {
		this.addClassName('gclms-disabled');
	},
	gotoLink: function() {
		if(this.getAttribute('gclms:confirm-text')) {
			gclms.popup.create({
				text: this.getAttribute('gclms:confirm-text'),
				confirmButtonText: __('Yes'),
				cancelButtonText: __('No'),
				type: 'confirm',
				callback: function() {
					location.href = this.getAttribute('href');
				}.bind(this)
			});
		} else {
			location.href = this.getAttribute('href');
		}
	}
};

gclms.Views = $H({});

gclms.Triggers = $H({
	'#UserLogin input#UserEmail:keyup,#UserLogin input#UserEmail:change,#UserLogin input#UserEmail:click,#UserLogin input#UserEmail:focus,#UserLogin input#UserEmail' : gclms.AppController.updateLoginPanel,
	'img.gclms-tooltip-button:mouseover': gclms.AppController.showTooltip,
	'img.gclms-tooltip-button:mouseout': gclms.AppController.hideTooltip,
	'.gclms-recordset' : {
		'tr:click,.gclms-descriptive-recordset tr:click' : function() {
			var tr = this.nodeName.toLowerCase() == 'tr' ? this : this.up('tr');
			self.location.href = tr.select('a').first().getAttribute('href').toLowerCase();
		},
		'.gclms-headers th:click,.gclms-pagination .gclms-right a:click,.gclms-pagination .gclms-left a:click' : function(event) {
			var element;
			if(this.nodeName == 'TH') {
				element = this.getElementsByTagName('a').item(0);
			} else {
				element = this;
			}
		
			if(!element || !element.getAttribute('href')) {
				return false;
			}
		
			var response = new Ajax.Updater('table',element.getAttribute('href'), {
				requestHeaders: ['X-Update', 'table'],
				onComplete: function() {
					$('table').observeRules(gclms.Triggers.get('.gclms-records'));
				}
			});
			event.stop();
		}
	},

	'.gclms-buttons': {
		'.gclms-button.gclms-add a:click': function(event) {
			if(this.getAttribute('gclms:link-href')) {
				event.stop();
				self.location.href = this.getAttribute('gclms:link-href');
			}
	
		},
		'button.gclms-delete:click': gclms.AppController.confirmRemove
	},
	'.gclms-content': {
		'.gclms-button:mousedown': function() {
			this.down('td').addClassName('gclms-pressed');
		},
		'.gclms-button:mouseup,.gclms-button:mouseout': function() {
			this.down('td').removeClassName('gclms-pressed');
		},
		'button[href]:click': gclms.AppController.gotoLink,
		'.gclms-records tr[href]:click': gclms.AppController.gotoLink,
		'form input[type="submit"]:click': gclms.AppController.submitForm
	},

	'body.gclms-install ul.gclms-menu a:click' : function(event) {
		event.stop();
	},
	'#gclms-choose-language select:change' : function(event) {
		event.findElement('form').submit();
	},
	
	/*
	'.gclms-content .gclms-step-back a:click' : function(event){
		if(!this.up('div').hasClassName('gclms-forceload')) {
			self.history.go(-1);
			event.stop();
		}
	},
	*/

	'.gclms-panel .gclms-top-right:click' : function(event) {
		var panel = $(this).up('.gclms-panel');
		var div = panel.select('.gclms-panel-content').first();
		var button = panel.select('.gclms-button').first();
		if(div.style.display == 'none') {
			div.displayAsBlock();
			button.removeClassName('gclms-down');
			button.addClassName('gclms-up');
		} else {
			div.hide();
			button.removeClassName('gclms-up');
			button.addClassName('gclms-down');
		}

		event.stop();
	}
});
	
gclms.popup = {
	'create' : gclms.AppController.createPopup
};

document.observe('dom:loaded', function() {
	$(document.body).observeRules(gclms.Triggers);
});

gclms.group = document.body.getAttribute('gclms-group');
gclms.course = document.body.getAttribute('gclms-course');
gclms.virtualClass = document.body.getAttribute('gclms-class');

if(gclms.group && gclms.course && gclms.virtualClass) {
	gclms.urlPrefix = '/' + gclms.group + '/' + gclms.course + '/' + gclms.virtualClass + '/';
} else if(gclms.group && gclms.course) {
	gclms.urlPrefix = '/' + gclms.group + '/' + gclms.course + '/';
}

gclms.simpleTinyMCEConfig = {
	theme : 'advanced',
	extended_valid_elements : 'a[name|href|target|title],em',
	theme_advanced_buttons1 : '',
	convert_urls: false,
	tab_focus : ':next',
	gecko_spellcheck: true,
	mode: "none",
	theme_advanced_toolbar_location : 'top',
	theme_advanced_toolbar_align : 'left',
	theme_advanced_buttons1 : 'italic,link,unlink,removeformat,pastetext,pasteword',
	theme_advanced_buttons2 : '',
	file_browser_callback : 'gclms.fileBrowser',
	width: '100%',
	height: '75px',
    language: document.body.getAttribute('gclms-language'),
	cleanup_serializer: 'xml',
	button_tile_map: true,
	theme_advanced_blockformats : '',
	skin: 'gclms',
	extended_valid_elements : 'a[name|href|target|title],em,i'
};

gclms.advancedTinyMCEConfig = {
    theme : 'advanced',
    plugins : 'media,inlinepopups,style,safari,paste', // sidebartext,notebook,safari
    language: document.body.getAttribute('gclms-language'),
    mode: 'none',
	button_tile_map: true,
	cleanup_serializer: 'xml',
	entity_encoding: 'raw',
	skin: 'gclms',
	width: '100%',
	height: '250px',
	convert_urls : false,
	theme_advanced_buttons1 : 'bold,italic,underline,separator,strikethrough,outdent,indent,justifyleft,justifycenter,justifyright,justifyfull,bullist,numlist,forecolor,backcolor,formatselect,styleselect,link,unlink,image,media,cleanup,removeformat,pastetext,pasteword,code,notebook', //,notebook,sidebartext
	theme_advanced_buttons2 : '',
	theme_advanced_buttons3_add : 'styleprops',
	theme_advanced_toolbar_location : 'top',
	theme_advanced_toolbar_align : 'left',
	theme_advanced_path_location : 'bottom',
    theme_advanced_blockformats : 'p,div,blockquote,h2,h3,h4',
	//content_css: '',
	gecko_spellcheck: true,
	theme : 'advanced',
	tab_focus : ':next',
	//theme_advanced_resize_horizontal: false,
	extended_valid_elements : 'a[name|href|target|title|onclick],img[class|src|border=0|alt|title|hspace|vspace|width|height|align|onmouseover|onmouseout|name],hr[class|width|size|noshade],font[face|size|color|style],span[class|align|style]',
	file_browser_callback : 'gclms.fileBrowser',
    setup : function(editor) {
        editor.addButton('notebook', {
            title : 'Add Notebook button',
            image : '/img/notebook-22.png',
            onclick : function() {
                editor.selection.setContent('<img src="/img/notebook-32.png" />');
            }
        });
    },
    class_filter : function(className, rule) {
        if (className.indexOf('gclms-') === 0) {
			return false;
		}
		
        if (className.indexOf('firebug') === 0) {
			return false;
		}
		
		if (className == 'error-message' || className == 'cake-sql-log') {
			return false;
		}
		
		return className;
    }
};

if(document.body.getAttribute('gclms-group') && !document.body.getAttribute('gclms-group').empty() &&
		document.body.getAttribute('gclms-course') && !document.body.getAttribute('gclms-course').empty()) { // && !document.body.getAttribute('gclms-course').empty()
	var cssTmp = '/'+ document.body.getAttribute('gclms-group') + '/'+ document.body.getAttribute('gclms-course') + '/files/css/' + new Date().getTime() + ',/css/' + document.body.getAttribute('gclms-direction') + '.css';
	gclms.simpleTinyMCEConfig.content_css = cssTmp;
	gclms.advancedTinyMCEConfig.content_css = cssTmp;
}

gclms.fileBrowser = function(field_name, url, type, win) {
	//alert("Field_Name: " + field_name + "\nURL: " + url + "\nType: " + type + "\nWin: " + win); // debug/testing

	if(type == 'image') {
		type = 'images';
	}

	var cmsURL;
	if(type == 'images' || type == 'media') {
	   	cmsURL = '/' + document.body.getAttribute('gclms-group') + '/' + document.body.getAttribute('gclms-course') + '/files/' + type + '/all';
	} else {
		cmsURL = '/' + document.body.getAttribute('gclms-group') + '/' + document.body.getAttribute('gclms-course') + '/courses/links/all';
	}

   tinyMCE.activeEditor.windowManager.open({
        file : cmsURL, // PHP session ID is now included if there is one at all
        title : "File Browser",
        width : 520,  // Your dimensions may differ - toy around with them!
        height : 450,
		scrollbars : 'yes',
		resizable : 'no',
        close_previous : 'yes',
		inline: 'yes'
    }, {
        window : win,
        input : field_name,
        editor_id : tinyMCE.selectedInstance.editorId
    });

	return false;
};