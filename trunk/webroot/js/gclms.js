/*global $, $$, Ajax, Element, GCLMS, Sortable, document, window, self, UUID, $F, $H, __ */

var GCLMS = {};

function __(text) {
	return GCLMS.translated_phrases[text]; 
}

GCLMS.translated_phrases = [];

GCLMS.AppController = {
	gotoFramedLink: function(event) {
		event.stop();
		location.href = this.getAttribute('href') + '?framed';
	},

	/*
	confirmRemove: function(event) {
		event.stop();
		GCLMS.popup.create({
			text: this.getAttribute('gclms:confirm-text'),
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
	*/
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
			className: 'gclms-ok',
			id: 'gclmsPopupDialogOkButton'
		})).insert(options.get('confirmButtonText'));
	
		div.select('button.gclms-ok').first().observe('click',function(event){
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
				className: 'gclms-cancel',
				id: 'gclms-popup-dialog-cancel-button'
			})).insert(options.get('cancelButtonText'));
			
			div.select('button.gclms-cancel').first().observe('click',function(event){
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
			//$('UserPasswordDiv').hide();
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
	},
	
	submitForm: function(event) {
		event.stop();
		
		var form = this.up('form');
		
		form.fire('gclms:submit');
		form.submit();
	}
};

GCLMS.Views = $H({});

GCLMS.Triggers = $H({
	'input#UserEmail:keyup,input#UserEmail:change,input#UserEmail:click,input#UserEmail:focus,input#UserEmail' : GCLMS.AppController.updateLoginPanel,
	'img.gclms-tooltip-button:mouseover': GCLMS.AppController.showTooltip,
	'img.gclms-tooltip-button:mouseout': GCLMS.AppController.hideTooltip,
	'.gclms-recordset' : {
		'.gclms-recordset tr:click,.gclms-descriptive-recordset tr:click' : function() {
			tr = this.nodeName.toLowerCase() == 'tr' ? this : this.up('tr');
			self.location.href = tr.select('a').first().getAttribute('href').toLowerCase();
		},
		'.gclms-headers th:click,.gclms-pagination .gclms-right a:click,.gclms-pagination .gclms-left a:click' : function(event) {
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
					$('table').observeRules(GCLMS.Triggers.get('.gclms-records'));
				}
			});
			event.stop();
		}
	},

	'.gclms-menubar button.gclms-add:click' : function(event) {
		if(this.getAttribute('link:href')) {
			self.location.href = this.getAttribute('link:href');
		}
	},
	'.gclms-content': {
		'.gclms-button.gclms-submit:click': GCLMS.AppController.submitForm,
		'.gclms-button.gclms-delete:click': GCLMS.AppController.confirmRemove,
		'.gclms-button:mousedown': function() {
			this.down('td').addClassName('gclms-pressed');
		},
		'.gclms-button:mouseup,.gclms-button:mouseout': function() {
			this.down('td').removeClassName('gclms-pressed');
		}
	},

	'body.gclms-install ul.gclms-menu a:click' : function(event) {
		event.stop();
	},
	'#gclms-choose-language select:change' : function(event) {
		event.findElement('form').submit();
	},
	
	'.gclms-content .gclms-step-back a:click' : function(event){
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
	GCLMS.group = document.body.getAttribute('gclms:group');
	GCLMS.course = document.body.getAttribute('gclms:course');
	GCLMS.virtualClass = document.body.getAttribute('gclms:virtual-class');
	
	if(GCLMS.group && GCLMS.course && GCLMS.virtualClass) {
		GCLMS.urlPrefix = '/' + GCLMS.group + '/' + GCLMS.course + '/' + GCLMS.virtualClass + '/';
	} else if(GCLMS.group && GCLMS.course) {
		GCLMS.urlPrefix = '/' + GCLMS.group + '/' + GCLMS.course + '/';
	}

	$(document.body).observeRules(GCLMS.Triggers);
	
	firstTextInput = $$('input[type="text"]:first');
	if(firstTextInput.length) {
		firstTextInput[0].focus();
		firstTextInput[0].select();
	}
});

GCLMS.simpleTinyMCEConfig = {
	theme : 'advanced',
	extended_valid_elements : 'a[name|href|target|title],em',
	theme_advanced_buttons1 : '',
	convert_urls: false,
	tab_focus : ':next',
	cleanup_serializer: 'xml',
	gecko_spellcheck: true,
	mode: "none",
	theme_advanced_toolbar_location : 'top',
	theme_advanced_toolbar_align : 'left',
	theme_advanced_buttons1 : 'italic,link,unlink,removeformat,pastetext,pasteword',
	theme_advanced_buttons2 : '',
	file_browser_callback : 'GCLMS.fileBrowser',
	width: '100%',
	height: '75px',
    language: document.body.getAttribute('gclms:language'),
	cleanup_serializer: 'xml',
	button_tile_map: true,
	theme_advanced_blockformats : '',
	skin: 'gclms',
	extended_valid_elements : 'a[name|href|target|title],em,i'
};

GCLMS.advancedTinyMCEConfig = {
    theme : 'advanced',
    plugins : 'media,inlinepopups,style,safari,paste', // sidebartext,notebook,safari
    language: document.body.getAttribute('gclms:language'),
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
	file_browser_callback : 'GCLMS.fileBrowser',
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

if(document.body.getAttribute('gclms:group') && !document.body.getAttribute('gclms:group').empty() &&
		document.body.getAttribute('gclms:course') && !document.body.getAttribute('gclms:course').empty()) { // && !document.body.getAttribute('gclms:course').empty()
	var cssTmp = '/'+ document.body.getAttribute('gclms:group') + '/'+ document.body.getAttribute('gclms:course') + '/files/css/' + new Date().getTime() + ',/css/' + document.body.getAttribute('gclms:direction') + '.css';
	GCLMS.simpleTinyMCEConfig.content_css = cssTmp;
	GCLMS.advancedTinyMCEConfig.content_css = cssTmp;
}

GCLMS.fileBrowser = function(field_name, url, type, win) {
	//alert("Field_Name: " + field_name + "\nURL: " + url + "\nType: " + type + "\nWin: " + win); // debug/testing

	if(type == 'image') {
		type = 'images';
	}

	if(type == 'images' || type == 'media') {
	   	cmsURL = '/' + document.body.getAttribute('gclms:group') + '/' + document.body.getAttribute('gclms:course') + '/files/' + type + '/all';
	} else {
		cmsURL = '/' + document.body.getAttribute('gclms:group') + '/' + document.body.getAttribute('gclms:course') + '/courses/links/all';
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