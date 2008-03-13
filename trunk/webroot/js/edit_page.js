tinyMCE.init(GCLMS.tinyMCEConfig);

GCLMS.PagesController = {
	enableTinyMCE: function() {
		tinyMCE.execCommand('mceAddControl', false, this.id);
	},

	configureMoveUpAndMoveDownButtons: function() {
		$$('button.moveUp[disabled="disabled"],button.moveDown[disabled="disabled"]').each(function(node){node.removeAttribute('disabled')});
		moveUpButtons = $$('button.moveUp');
		if(!moveUpButtons.first())
			return true;
		moveUpButtons.first().setAttribute('disabled','disabled');
		$$('button.moveDown').last().setAttribute('disabled','disabled');
	},
	
	insertTextareaOnTopOfPage: function(event) {
		event.stop();
		GCLMS.PagesController.insertTextarea(this.up('div.gclms-top-buttons'));
	},
	
	insertTextareaBelowPageItem: function(event) {
		event.stop();
		GCLMS.PagesController.insertTextarea(this.up('div.gclms-page-item'));
	},
	
	insertTextarea: function(div) {
		test = div.insert({after: GCLMS.Views.get('textarea').interpolate({id: UUID.generate()})});
		div.next('div.gclms-page-item').observeRules(GCLMS.Triggers.get('.gclms-edit-page')['.gclms-page-item']);
		GCLMS.PagesController.configureMoveUpAndMoveDownButtons();
		var windowHeight = window.innerHeight ? window.innerHeight : document.documentElement.clientHeight ? document.documentElement.clientHeight : document.body.clientHeight;
		if((test.cumulativeOffset().top + test.offsetHeight + 500) > (document.body.scrollTop + windowHeight)) {
			scroll(0,test.cumulativeOffset().top);
		}
	},
	
	insertQuestionOnTopOfPage: function(event) {
		event.stop();
		if(!event.isLeftClick()) return false;
		GCLMS.PagesController.insertQuestion(this.up('div.gclms-top-buttons'));
	},
	
	insertQuestionBelowPageItem: function(event) {
		event.stop();
		GCLMS.PagesController.insertQuestion(this.up('div.gclms-page-item'));
	},
	
	insertQuestion: function(div) {
		test = div.insert({after: GCLMS.Views.get('question').interpolate({id: UUID.generate()})});
		nextDiv = div.next('div.gclms-page-item');
		nextDiv.observeRules(GCLMS.Triggers.get('.gclms-edit-page')['.gclms-page-item']);
		GCLMS.PagesController.configureMoveUpAndMoveDownButtons();
		var windowHeight = window.innerHeight ? window.innerHeight : document.documentElement.clientHeight ? document.documentElement.clientHeight : document.body.clientHeight;
		if((test.cumulativeOffset().top + test.offsetHeight + 150) > (document.body.scrollTop + windowHeight)) {
			scroll(0,test.cumulativeOffset().top);
		}
	},
	
	loadTextareas: function() {
		GCLMS.Views.update({
			textarea: tmpTextareaView,
			question: tmpQuestionView,
			multipleChoiceAnswer: tmpMultipleChoiceAnswerView,
			matchingAnswer: tmpMatchingAnswerView
		});
	},
	
	submitForm: function(event) {
		order = 0;
		
		noQuestionTitlesEmpty = true;
		$$('input.gclms-question-title').each(function(node){
			if($F(node).empty())
				noQuestionTitlesEmpty = false;		
		});
		if(!noQuestionTitlesEmpty) {
			GCLMS.popup.create({
				text: this.getAttribute('gclms:no-empty-question-title-message'),
				cancelButtonText: null,
				type: 'alert'
			});
			event.stop();
		}
		
		$$('div.gclms-page-item').each(function(node){
			if(node.hasClassName('textarea')) {
				id = node.getAttribute('textarea:id');
				type = 'Textarea';
			} else {
				id = node.getAttribute('question:id');
				type = 'Question';
			}

			$(this).insert(new Element('input', {
				name: 'data[' + type + '][' + id + '][order]',
				value: ++order,
				type: 'hidden'
			}));
		}.bind(this));
	},
	
	changePageAudio: function(event){
		if($F(this) == 'External URL') {
			$('PageExternalAudioFile').displayAsInline();
			$('PageExternalAudioFile').disabled = false;
			if(event) {
				$('PageExternalAudioFile').focus();
				$('PageExternalAudioFile').select();
			}
		} else {
			$('PageExternalAudioFile').hide();
			$('PageExternalAudioFile').disabled = true;
		}
	},
	
	moveItem: function(event) {
		event.stop();
		pageItem = this.up('div.gclms-page-item');

		if(this.hasClassName('moveDown') && !(adjacentPageItem = pageItem.next('div.gclms-page-item')))
			return false;
		else if(this.hasClassName('moveUp') && !(adjacentPageItem = pageItem.previous('div.gclms-page-item')))
			return false;

		if(pageItem.hasClassName('textarea') && adjacentPageItem.hasClassName('question')) {
			// A trick to avoid reloading the TinyMCE component if possible
			if(this.hasClassName('moveDown'))
				pageItem.insert({before: adjacentPageItem});
			else
				pageItem.insert({after: adjacentPageItem})
		} else {
			if(pageItem.hasClassName('textarea'))
				tinyMCE.execCommand('mceRemoveControl', false, pageItem.select('textarea').first().id);

			if(this.hasClassName('moveDown'))
				adjacentPageItem.insert({after: pageItem});
			else
				adjacentPageItem.insert({before: pageItem})

			if(pageItem.hasClassName('textarea'))
				tinyMCE.execCommand('mceAddControl', false, pageItem.select('textarea').first().id);
		}

		GCLMS.PagesController.configureMoveUpAndMoveDownButtons();
	},
	
	confirmDeleteMatchingAnswer: function(event) {
		event.stop();
		this.style.color = 'red';
				
		GCLMS.popup.create({
			text: this.getAttribute('confirm:text'),
			confirmButtonText: __('Yes'),
			cancelButtonText: __('No'),
			type: 'confirm',
			callback: GCLMS.PagesController.deleteMatchingAnswer.bind(this),
			cancelCallback: function(){
				this.style.color = '';
			}.bind(this)
		});
		return false;
	},
	
	deleteMatchingAnswer: function() {
		this.up('div').remove();
	},
	
	confirmDeleteQuestion: function(event) {
		event.stop();
		this.style.color = 'red';
				
		GCLMS.popup.create({
			text: this.getAttribute('confirm:text'),
			confirmButtonText: __('Yes'),
			cancelButtonText: __('No'),
			type: 'confirm',
			callback: GCLMS.PagesController.deleteQuestion.bind(this),
			cancelCallback: function(){
				this.style.color = '';
			}.bind(this)
		});
		return false;
	},
	
	deleteQuestion: function() {
		this.up('div.gclms-page-item').remove();
		GCLMS.PagesController.configureMoveUpAndMoveDownButtons();
	},
	
	confirmDeleteTextarea: function(event) {
		event.stop();
		this.style.color = 'red';
				
		GCLMS.popup.create({
			text: this.getAttribute('confirm:text'),
			confirmButtonText: __('Yes'),
			cancelButtonText: __('No'),
			type: 'confirm',
			callback: GCLMS.PagesController.deleteTextarea.bind(this),
			cancelCallback: function(){
				this.style.color = '';
			}.bind(this)
		});
		return false;
	},
	
	deleteTextarea: function() {
		div = this.up('div.gclms-page-item')
		div.select('textarea').each(function(node){
			tinyMCE.execCommand('mceRemoveControl', false, node.id);
		});

		div.remove();
		GCLMS.PagesController.configureMoveUpAndMoveDownButtons();
	},
	
	selectQuestionType: function(event) {
		div = this.up('div');

		switch(this.value) {
			case '0': // Multiple choice
				div.select('.multipleChoice')[0].displayAsTableRow();
				div.select('.trueFalse')[0].hide();
				div.select('.fillInTheBlank')[0].hide();
				div.select('.matching')[0].hide();
				div.select('.matchingHeaders')[0].hide();
				break;
			case '1': // True/false
				div.select('.multipleChoice')[0].hide();
				div.select('.trueFalse')[0].displayAsTableRow();
				div.select('.fillInTheBlank')[0].hide();
				div.select('.matching')[0].hide();
				div.select('.matchingHeaders')[0].hide();
				break;
			case '2': // Fill in the blank
				div.select('.multipleChoice')[0].hide();
				div.select('.trueFalse')[0].hide();
				div.select('.fillInTheBlank')[0].displayAsTableRow();
				div.select('.matching')[0].hide();
				div.select('.matchingHeaders')[0].hide();
				div.select('.fillInTheBlank')[0].getElementsByTagName('input')[0].focus();
				break;
			case '3': // Matching
				div.select('.multipleChoice')[0].hide();
				div.select('.trueFalse')[0].hide();
				div.select('.fillInTheBlank')[0].hide();
				div.select('.matching')[0].displayAsTableRow();
				div.select('.matchingHeaders')[0].displayAsTableRow();
				break;
		}
	},
	
	addMultipleChoiceAnswer: function(event) {
		div = this.up('div');

		answersDiv = div.select('tr.multipleChoice .answers').first();
		answersDiv.insert(GCLMS.Views.get('multipleChoiceAnswer'));
		answersDiv.displayAsBlock();
		lastTable = answersDiv.select('table').last();
		lastTable.observeRules(GCLMS.Triggers.get('.gclms-edit-page')['.gclms-page-item']['tr.multipleChoice,tr.matching']);
		lastTable.parentNode.displayAsBlock();		
		event.stop();

		//this.select('input[type="text"]').first().focus();
	},
	
	addMatchingAnswer: function(event) {
		div = this.up('div');
		
		answersDiv = div.select('tr.matching .answers').first();
		answersDiv.insert(GCLMS.Views.get('matchingAnswer'));
		answersDiv.displayAsBlock();
		lastTable = answersDiv.select('table').last();
		lastTable.observeRules(GCLMS.Triggers.get('.gclms-edit-page')['.gclms-page-item']['tr.multipleChoice,tr.matching']);
		lastTable.parentNode.displayAsBlock();
		event.stop();
		
		//this.select('input[type="text"]').first().focus();
	}
}

GCLMS.Triggers.update({
	'.gclms-edit-page' : {
		':loaded': 										GCLMS.PagesController.loadTextareas,
		'form:submit': 									GCLMS.PagesController.submitForm,
		'#PageAudioFile,#PageAudioFile:change': 		GCLMS.PagesController.changePageAudio,
		'.gclms-top-buttons' : {
			'.insertTextarea:click':					GCLMS.PagesController.insertTextareaOnTopOfPage,
			'.insertQuestion:click':					GCLMS.PagesController.insertQuestionOnTopOfPage
		},

		'.gclms-page-item' : {
			':loaded': 									GCLMS.PagesController.configureMoveUpAndMoveDownButtons,
			'textarea': 								GCLMS.PagesController.enableTinyMCE,
			'.moveDown:click,.moveUp:click':			GCLMS.PagesController.moveItem,
			'.insertTextarea:click':					GCLMS.PagesController.insertTextareaBelowPageItem,
			'.insertQuestion:click':					GCLMS.PagesController.insertQuestionBelowPageItem,
			'tr.multipleChoice,tr.matching' : {
				'button.deleteAnswer:click':			GCLMS.PagesController.confirmDeleteMatchingAnswer
			},
			'button.deleteQuestion:click':				GCLMS.PagesController.confirmDeleteQuestion,
			'button.deleteTextarea:click':				GCLMS.PagesController.confirmDeleteTextarea,
			'input[type="radio"].questionType:click':	GCLMS.PagesController.selectQuestionType,
			'.multipleChoice button.add:click':			GCLMS.PagesController.addMultipleChoiceAnswer,
			'.matching button.add:click':				GCLMS.PagesController.addMatchingAnswer
		}
	}
});