gclms.popup = Class.create({
	initialize: function(options) {
		this.options = $H({
			modal: false,
			value: '',
			confirmButtonText: 'OK',
			cancelButtonText: 'Cancel',
			callback: null,
			cancelCallback: null,
			text: null
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

		this.setup();

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
		
		// Vertically center the dialog
		this.dialog.setStyle({marginTop: (this.overlay.offsetHeight / 2) -  (this.dialog.offsetHeight / 2) + 'px'});
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
	}
});

gclms.alert = Class.create(gclms.popup, {
	initialize: function($super, options) {
		$super(options);
	},
	
	setup: function() {
		this.dialog.insert(new Element('p').insert(this.options.get('text')));
		this.addButtonsContainer();
		this.addOkButton();		
	}
});

gclms.confirm = Class.create(gclms.popup, {
	initialize: function($super, options) {
		$super(options);
	},
	
	setup: function() {
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
	
	setup: function() {
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
				this.up('div.gclms-popup-overlay').remove();	
				if(this.options.get('cancelCallback')) {
					this.options.get('cancelCallback')();
				}
			}
			if(event.keyCode == Event.KEY_RETURN) {
				this.up('div.gclms-popup-overlay').remove();
				if(this.options.get('callback')) {
					this.options.get('callback')(this.dialog.select('input[type="text"]').first().value);
				}
			}
		});
		
		this.getCallbackValue = function() {
			return this.dialog.select('input[type="text"]').first().value;
		};
	}
});

gclms.search = Class.create(gclms.popup, {
	initialize: function($super, options) {
		$super(options);
	},
	
	setup: function() {
		var template = '<div class="gclms-title">Search for User</div><form><div><label>Username or e-mail</label><br/>'
			+ '<table><tbody><tr><td><input type="text" id="gclms-search-input"></td><td><button>Search</button></td></tr></tbody></table></form></div>'
			+ '<div id="gclm-search-results"></div>';
		this.dialog.insert(template);
	}
});