/* global $, $$, Ajax, Element, GCLMS, Sortable, document, window, self, UUID, __ */

var GCLMS = {};

function __(text) {
	//Just for now...
	switch(text) {
		case 'Yes':
			return '<u>Y</u>es';
		case 'No':
			return '<u>N</u>o';
	}
	return text; 
}

GCLMS.AppController = {
	confirmRemove: function(event) {
		event.stop();
		GCLMS.popup.create({
			text: this.getAttribute('confirm:text'),
			confirmButtonText: __('Yes'),
			cancelButtonText: __('No'),
			type: 'confirm',
			callback: GCLMS.AppController.remove.bind(this)
		});
	},
	remove: function() {
		form = this.up('form');
		if(form.getAttribute('gclms:deleteAction')) {
			self.location.href = form.getAttribute('gclms:deleteAction');
		} else {
			action = this.up('form').getAttribute('action').split('edit');
			self.location.href = action[0] + 'delete' + action[1];
		}
	},
	showTooltip: function() {
		if(!GCLMS.tooltip) {
			GCLMS.tooltip = new Element('div', {
				id: 'gclms-tooltip'
			});			
			GCLMS.tooltip.appendChild(
				new Element('div',{
					id: 'gclms-tooltip-content'
				})
			);
			document.body.appendChild(GCLMS.tooltip);		
		}
		$('gclms-tooltip-content').update(this.getAttribute('tooltip:text'));	
		$('gclms-tooltip').displayAsBlock();
		$('gclms-tooltip').setStyle({
			left: (this.cumulativeOffset()[0] + this.getWidth()) + 'px',
			top: (this.cumulativeOffset()[1] - GCLMS.tooltip.getHeight()) + 'px'
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
	
		GCLMS.popup.callback = options.get('callback');
		GCLMS.popup.cancelCallback = options.get('cancelCallback');
			
		if(!GCLMS.popup.overlay) {
			GCLMS.popup.overlay = new Element('div',{
				className: 'gclms-popup-overlay'
			});
			GCLMS.popup.overlay.observe('click',function(event) {
				GCLMS.popup.overlay.hide();
			});
		}
		GCLMS.popup.overlay.style.display = 'block';
		
		
		if(GCLMS.popup.dialog) {
			GCLMS.popup.dialog.remove();
		}
		
		GCLMS.popup.dialog = new Element('div',{
			className: 'gclms-popup-dialog'
		});
		document.body.insert(GCLMS.popup.overlay);
	
		GCLMS.popup.dialog.insert(new Element('p').insert(options.get('text')));
	
		if(options.get('type') == 'prompt'){
			GCLMS.popup.dialog.insert(new Element('p').insert(new Element('input',{
				type: 'text',
				id: 'gclmsPopupDialogInputText',
				value: options.get('value')
			})));
			GCLMS.popup.dialog.select('input[type="text"]').first().observe('keydown',function(event){
				if(event.keyCode == Event.KEY_ESC) {
					this.up('div.gclms-popup-overlay').hide();	
					if(GCLMS.popup.cancelCallback) {
						GCLMS.popup.cancelCallback();
					}
				}
				if(event.keyCode == Event.KEY_RETURN) {
					this.up('div.gclms-popup-overlay').hide();
					if(GCLMS.popup.callback) {
						GCLMS.popup.callback(GCLMS.popup.dialog.select('input[type="text"]').first().value);
					}
				}
			});
			
			GCLMS.popup.getCallbackValue = function() {
				return GCLMS.popup.dialog.select('input[type="text"]').first().value;
			};
		} else if(options.get('type') == 'confirm'){
			GCLMS.popup.getCallbackValue = function() {
				return true;
			};			
		}
		
		var div = new Element('div');
		div.appendChild(new Element('button',{
			className: 'ok',
			id: 'gclmsPopupDialogOkButton'
		})).insert(options.get('confirmButtonText'));
	
		div.select('button.ok').first().observe('click',function(event){
			GCLMS.AppController.closePopup({executeCallback: true});
		});
		
		if(options.get('type') == 'confirm') {
			GCLMS.popup.keyDownHandler = function(event) {
				if (event.keyCode == 89) {
					GCLMS.AppController.closePopup({executeCallback: true});
				} else if (event.keyCode == 78) {
					GCLMS.AppController.closePopup({executeCallback: false});
				}
			};
			document.observe('keydown',GCLMS.popup.keyDownHandler);
		}
		
		if(options.get('cancelButtonText') !== null) {
			div.appendChild(new Element('button',{
				className: 'cancel',
				id: 'gclms-popup-dialog-cancel-button'
			})).insert(options.get('cancelButtonText'));
			
			div.select('button.cancel').first().observe('click',function(event){
				GCLMS.AppController.closePopup({executeCallback: false});
			});
		}
	
		GCLMS.popup.dialog.insert(div);
		
		GCLMS.popup.dialog.observe('click',function(event){
			event.stop();
		});
		
		GCLMS.popup.overlay.insert(GCLMS.popup.dialog);
		if(GCLMS.popup.dialog.select('input[type="text"]').first()) {
			GCLMS.popup.dialog.select('input[type="text"]').first().focus();
			GCLMS.popup.dialog.select('input[type="text"]').first().select();
		}
		
		// Vertically center the dialog
		GCLMS.popup.dialog.setStyle({marginTop: (GCLMS.popup.overlay.offsetHeight / 2) -  (GCLMS.popup.dialog.offsetHeight / 2) + 'px'});
	},
	closePopup: function(options) {
		$$('div.gclms-popup-overlay').first().hide();
		document.stopObserving('keydown',GCLMS.popup.keyDownHandler);
		if (options.executeCallback && GCLMS.popup.callback) {
			GCLMS.popup.callback(GCLMS.popup.getCallbackValue());
		} else if (GCLMS.popup.cancelCallback) {
			GCLMS.popup.cancelCallback();
		}
	},
	updateLoginPanel: function(event) {
		//alert(event.keyCode)
		if($F(this).indexOf('@') != -1) {
			$('UserPasswordDiv').displayAsBlock();
		} else {
			$('UserPasswordDiv').hide();
		}
		
		if($F('UserEmail').trim().indexOf('http:') === 0) {
			if(!$('UserEmail').hasClassName('gclms-openid')) {
				$('UserEmail').addClassName('gclms-openid');
			}
		} else {
			if($('UserEmail').hasClassName('gclms-openid')) {
				$('UserEmail').removeClassName('gclms-openid');				
			}
		}
	}
};

GCLMS.Views = $H({});

GCLMS.Triggers = $H({
	'input#UserEmail:keyup,input#UserEmail:change,input#UserEmail:click,input#UserEmail:focus,input#UserEmail' : GCLMS.AppController.updateLoginPanel,
	'img.gclms-tooltip-button:mouseover': GCLMS.AppController.showTooltip,
	'img.gclms-tooltip-button:mouseout': GCLMS.AppController.hideTooltip,
	'.Records' : {
		'.gclms-recordset tr:click,.gclms-descriptive-recordset tr:click' : function() {
			tr = this.nodeName.toLowerCase() == 'tr' ? this : this.up('tr');
			self.location.href = tr.select('a').first().getAttribute('href').toLowerCase();
		},
		'.Headers th:click,.Pagination .Right a:click,.Pagination .Left a:click' : function(event) {
			if(this.nodeName == 'TH') {
				element = this.getElementsByTagName('a').item(0);
			} else {
				element = this;
			}
		
			if(!element || !element.getAttribute('href')) {
				return false;
			}
		
			response = new Ajax.Updater('table',element.getAttribute('href'), {
				requestHeaders: ['X-Update', 'table'],
				onComplete: function() {
					$('table').observeRules(GCLMS.Triggers.get('.Records'));
				}
			});
			event.stop();
		}
	},

	'.gclms-menubar button.gclms-add:click' : function(event) {
		self.location.href = this.getAttribute('link:href').toLowerCase();
	},
	'.gclms-content input.delete:click' : GCLMS.AppController.confirmRemove,
	'body.gclms-install ul.gclms-menu a:click' : function(event) {
		event.stop();
	},
	'#gclms-choose-language select:change' : function(event) {
		event.findElement('form').submit();
	},
	
	'.Content .stepBack a:click' : function(event){
		if(!this.up('div').hasClassName('gclms-forceload')) {
			history.go(-1);
			event.stop();
		}
	},

	'.gclms-panel .gclms-top-right:click' : function(event) {
		panel = $(this).up('.gclms-panel');
		div = panel.select('.gclms-panel-content').first();
		button = panel.select('.gclms-button').first();
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
	
GCLMS.popup = {
	'create' : GCLMS.AppController.createPopup
};

document.observe("dom:loaded", function() {
	$(document.body).observeRules(GCLMS.Triggers);
	
	firstTextInput = $$('input[type="text"]:first');
	if(firstTextInput.length) {
		firstTextInput[0].focus();
		firstTextInput[0].select();
	}
});

GCLMS.tinyMCEConfig = {
    theme : 'advanced',
    plugins : 'media,inlinepopups,style', // sidebartext,notebook
    mode: 'none',
	skin: 'gclms',
	relative_urls : false,
    editor_selector : 'wysiwyg',
	theme_advanced_buttons1 : 'bold,italic,underline,separator,strikethrough,outdent,indent,justifyleft,justifycenter,justifyright,justifyfull,bullist,numlist,forecolor,backcolor,formatselect,styleselect,link,unlink,image,media,cleanup,code', //,notebook,sidebartext
	theme_advanced_buttons2 : '',
	theme_advanced_buttons3_add : 'styleprops',
	theme_advanced_toolbar_location : 'top',
	theme_advanced_toolbar_align : 'left',
	theme_advanced_path_location : 'bottom',
    theme_advanced_blockformats : 'p,h2,h3,h4',
	theme_advanced_toolbar_location : 'external',
	theme_advanced_resizing: true,
	gecko_spellcheck: true,
	theme : 'advanced',
	tab_focus : ':next',
	theme_advanced_resize_horizontal: false,
	extended_valid_elements : 'a[name|href|target|title|onclick],img[class|src|border=0|alt|title|hspace|vspace|width|height|align|onmouseover|onmouseout|name],hr[class|width|size|noshade],font[face|size|color|style],span[class|align|style]',
	file_browser_callback : 'GCLMS.fileBrowser',
	content_css : "/css/main.css,/css/page.css"
};

if(document.body.getAttribute('lms:group') && !document.body.getAttribute('lms:group').empty() && !document.body.getAttribute('lms:course').empty()) {
	//GCLMS.tinyMCEConfig.content_css = '/css/reset.css, ' + '/css/main.css, ' + '/' + document.body.getAttribute('lms:group') + '/' + document.body.getAttribute('lms:course') + '/files/css' + '/1';
}

GCLMS.fileBrowser = function(field_name, url, type, win) {
	//alert("Field_Name: " + field_name + "\nURL: " + url + "\nType: " + type + "\nWin: " + win); // debug/testing

	if(type == 'image') {
		type = 'images';
	}

	if(type == 'images' || type == 'media') {
	   	cmsURL = '/' + document.body.getAttribute('lms:group') + '/' + document.body.getAttribute('lms:course') + '/files/' + type;
	} else {
		cmsURL = '/' + document.body.getAttribute('lms:group') + '/' + document.body.getAttribute('lms:course') + '/courses/links';
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