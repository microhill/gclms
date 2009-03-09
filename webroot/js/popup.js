gclms.popup = Class.create({
	initialize: function(options) {
		this.options = $H({
			modal: false,
			value: '',
			confirmButtonText: 'OK',
			cancelButtonText: 'Cancel',
			callback: null,
			cancelCallback: null,
			text: null,
			height: null,
			width: null
		}).update(options);
		
		this.overlay = new Element('div',{
			className: 'gclms-popup-overlay'
		});
		this.overlay.observe('click',function(event) {
			this.overlay.remove();
		}.bind(this));
		this.overlay.style.display = 'block';
		
		this.dialog = new Element('div',{
			className: 'gclms-popup-dialog'
		});
		
		document.body.insert(this.overlay);

		this.beforeSetup();

		if(this.buttons)
			this.dialog.insert(this.buttons);
		
		this.dialog.observe('click',function(event){
			event.stop();
		});
		
		this.overlay.insert(this.dialog);
		
		if(this.dialog.select('input[type="text"]').first()) {
			this.dialog.select('input[type="text"]').first().focus();
			this.dialog.select('input[type="text"]').first().select();
		}
		
		//Width
		if(this.options.get('width')) {
			this.dialog.setStyle({
				width: this.options.get('width') + 'px'
			});
		}

		//Height
		if(this.options.get('height')) {
			this.dialog.setStyle({
				height: this.options.get('height') + 'px',
				overflow: 'auto'
			});
		}
		
		// Vertically center the dialog
		this.dialog.setStyle({marginTop: (this.overlay.offsetHeight / 2) -  (this.dialog.offsetHeight / 2) + 'px'});
		
		this.afterSetup();
	},

	close: function(options) {
		$$('div.gclms-popup-overlay').first().remove();

		document.stopObserving('keydown',this.keyDownHandler);

		if (options.executeCallback && this.options.get('callback')) {
			this.options.get('callback')(this.getCallbackValue());
		} else if (this.options.get('cancelCallback')) {
			this.options.get('cancelCallback')();
		}
	},
	
	addButtonsContainer: function() {
		this.buttons = new Element('div').insert(new Element('table',{className: 'gclms-buttons'}).insert(new Element('tbody').insert(new Element('tr'))));
	},
	
	addOkButton: function() {
		this.buttons.down('tr').insert(new Element('td').insert(new Element('button',{
			className: 'gclms-ok',
			id: 'gclms-popup-dialog-ok-button'
		}).insert(this.options.get('confirmButtonText'))));
	
		this.buttons.select('button').last().observe('click',function(event){
			this.close({executeCallback: true});
		}.bind(this));
	},
	
	addCancelButton: function() {
		this.buttons.down('tr').insert(new Element('td').insert(new Element('button',{
			className: 'gclms-cancel',
			id: 'gclms-popup-dialog-cancel-button'
		}).insert(this.options.get('cancelButtonText'))));
		
		this.buttons.select('button').last().observe('click',function(event){
			this.close({executeCallback: false});
		}.bind(this));
	},
	
	beforeSetup: function() {},
	afterSetup: function() {}
});

gclms.selector = Class.create(gclms.popup, {
	initialize: function($super, options) {
		$super(options);
	},
	
	afterSetup: function() {
		this.close_button = new Element('img',{
			src: '/img/popup/close-button-20.png'
		});		
		this.overlay.insert(this.close_button);
		var position = this.dialog.cumulativeOffset();
		this.close_button.setStyle({
			position: 'fixed',
			left: position.left - 8 + 'px',
			top: position.top - 8 + 'px',
		});	
		
		this.spinner = new Element('img',{
			src: '/img/spinner.gif'
		});		
		this.dialog.insert(this.spinner);
		this.spinner.setStyle({
			position: 'fixed',
			left: position.left + (this.dialog.getWidth() / 2) - 8 + 'px',
			top: position.top + (this.dialog.getHeight() / 2) - 8 + 'px',
		});	
		
		var request = new Ajax.Request(this.options.get('url'), {
			method: 'get',
			onSuccess: function(transport) {
				this.dialog.update(transport.responseText);
				this.dialog.select('.gclms-callback').each(function(a){
					a.observe('click',function(event) {
						if(this.options.get('callback')(event.element()))
							this.close();
					}.bind(this));					
				}.bind(this));
			}.bind(this)
		});
	}
});

gclms.alert = Class.create(gclms.popup, {
	initialize: function($super, options) {
		$super(options);
	},
	
	beforeSetup: function() {
		this.dialog.insert(new Element('p').insert(this.options.get('text')));
		this.addButtonsContainer();
		this.addOkButton();		
	}
});

gclms.confirm = Class.create(gclms.popup, {
	initialize: function($super, options) {
		$super(options);
	},
	
	beforeSetup: function() {
		this.dialog.insert(new Element('p').insert(this.options.get('text')));
		this.addButtonsContainer();
		this.addOkButton();
		this.addCancelButton();

		this.keyDownHandler = function(event) {
			if (event.keyCode == 89) {
				this.close({executeCallback: true});
			} else if (event.keyCode == 78) {
				this.close({executeCallback: false});
			}
		}.bind(this);
		document.observe('keydown',this.keyDownHandler);

		this.getCallbackValue = function() {
			return true;
		};	
	}
});

gclms.prompt = Class.create(gclms.popup, {
	initialize: function($super, options) {
		$super(options);
	},
	
	beforeSetup: function() {
		this.dialog.insert(new Element('p').insert(this.options.get('text')));
		this.addButtonsContainer();
		this.addOkButton();
		this.addCancelButton();
		
		this.dialog.insert(new Element('p').insert(new Element('input',{
			type: 'text',
			id: 'gclmsPopupDialogInputText',
			value: this.options.get('value')
		})));
		
		this.dialog.select('input[type="text"]').first().observe('keydown',function(event){
			if(event.keyCode == Event.KEY_ESC) {
				$('gclms-popup-dialog-ok-button').up('div.gclms-popup-overlay').remove();	
				if(this.options.get('cancelCallback')) {
					this.options.get('cancelCallback')();
				}
			}
			if(event.keyCode == Event.KEY_RETURN) {
				$('gclms-popup-dialog-ok-button').up('div.gclms-popup-overlay').remove();
				if(this.options.get('callback')) {
					this.options.get('callback')(this.dialog.select('input[type="text"]').first().value);
				}
			}
		}.bind(this));
		
		this.getCallbackValue = function() {
			return this.dialog.select('input[type="text"]').first().value;
		};
	}
});

gclms.search = Class.create(gclms.popup, {
	initialize: function($super, options) {
		$super(options);
	},
	
	beforeSetup: function() {
		var template = '<div class="gclms-title">Search for User</div><form><div><label>Username or e-mail</label><br/>'
			+ '<table><tbody><tr><td><input type="text" id="gclms-search-input"></td><td><button>Search</button></td></tr></tbody></table></form></div>'
			+ '<div id="gclm-search-results"></div>';
		this.dialog.insert(template);
	}
});