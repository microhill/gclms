/*global $, $$, $F, Ajax, Element, GCLMS, Sortable, document, window, tinyMCE, self, UUID, __, tmpTextareaView, tmpQuestionView, tmpQuestionExplanationView, tmpMultipleChoiceAnswerView, tmpMultipleChoiceAnswerExplanationView, tmpMatchingAnswerView, tmpOrderAnswerView */

tinyMCE.init(GCLMS.tinyMCEConfig);

GCLMS.PagesController = {
	addExplanationToQuestion: function() {
		var div = this.up('div.question');
		var questionId = div.getAttribute('question:id');
		
		this.replace(GCLMS.Views.get('questionExplanation').interpolate({id: questionId}));
		
		GCLMS.PagesController.enableTinyMCE.bind(div.down('textarea.gclms-question-explanation'))();
		div.down('tr.question-explanation td').addClassName('filled');
	},
	
	addExplanationToMultipleChoiceAnswer: function() {
		var questionDiv = this.up('div.question');
		var questionId = questionDiv.getAttribute('question:id');
		
		var div = this.up('div.multipleChoice');
		var answerId = div.getAttribute('gclms:answer-id');
		this.replace(GCLMS.Views.get('multipleChoiceAnswerExplanation').interpolate({answer_id: answerId,question_id: questionId}));
		
		GCLMS.tinyMCEConfig.height = '75px';
		GCLMS.PagesController.enableTinyMCE.bind(div.down('textarea.gclms-answer-explanation'))();
		div.down('tr.answer-explanation td').addClassName('filled');
	},

	enableTinyMCE: function() {
		tinyMCE.execCommand('mceAddControl', true, this.id);
		GCLMS.tinyMCEConfig.height = '250px';
	},

	configureMoveUpAndMoveDownButtons: function() {
		$$('img.moveUp[disabled="disabled"],img.moveDown[disabled="disabled"]').each(function(node){node.removeAttribute('disabled');});
		var moveUpButtons = $$('img.moveUp');
		if (!moveUpButtons.first()) {
			return true;
		}
		moveUpButtons.first().setAttribute('disabled','disabled');
		$$('img.moveDown').last().setAttribute('disabled','disabled');
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
		var test = div.insert({after: GCLMS.Views.get('textarea').interpolate({id: UUID.generate()})});
		div.next('div.gclms-page-item').observeRules(GCLMS.Triggers.get('.gclms-edit-page')['.gclms-page-item']);
		GCLMS.PagesController.configureMoveUpAndMoveDownButtons();
		var windowHeight = window.innerHeight ? window.innerHeight : document.documentElement.clientHeight ? document.documentElement.clientHeight : document.body.clientHeight;
		if((test.cumulativeOffset().top + test.offsetHeight + 500) > (document.body.scrollTop + windowHeight)) {
			scroll(0,test.cumulativeOffset().top);
		}
	},
	
	insertQuestionOnTopOfPage: function(event) {
		event.stop();
		if(!event.isLeftClick()) {
			return false;
		}
		GCLMS.PagesController.insertQuestion(this.up('div.gclms-top-buttons'));
	},
	
	insertQuestionBelowPageItem: function(event) {
		event.stop();
		GCLMS.PagesController.insertQuestion(this.up('div.gclms-page-item'));
	},
	
	insertQuestion: function(div) {
		var test = div.insert({after: GCLMS.Views.get('question').interpolate({id: UUID.generate()})});
		var nextDiv = div.next('div.gclms-page-item');
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
			questionExplanation: tmpQuestionExplanationView,			
			multipleChoiceAnswer: tmpMultipleChoiceAnswerView,
			multipleChoiceAnswerExplanation: tmpMultipleChoiceAnswerExplanationView,
			matchingAnswer: tmpMatchingAnswerView,
			orderAnswer: tmpOrderAnswerView
		});
	},
	
	submitForm: function(event) {
		var order = 0;
		
		var noQuestionTitlesEmpty = true;
		$$('input.gclms-question-title').each(function(node){
			if ($F(node).empty()) {
				noQuestionTitlesEmpty = false;
			}
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

		if (this.hasClassName('moveDown') && !(adjacentPageItem = pageItem.next('div.gclms-page-item'))) {
			return false;
		} else if (this.hasClassName('moveUp') && !(adjacentPageItem = pageItem.previous('div.gclms-page-item'))) {
			return false;
		}

		if(pageItem.hasClassName('textarea') && adjacentPageItem.hasClassName('question')) {
			// A trick to avoid reloading the TinyMCE component if possible
			if (this.hasClassName('moveDown')) {
				pageItem.insert({
					before: adjacentPageItem
				});
			}
			else {
				pageItem.insert({
					after: adjacentPageItem
				});
			}
		} else {
			if (pageItem.hasClassName('textarea')) {
				tinyMCE.execCommand('mceRemoveControl', false, pageItem.down('textarea').id);
			}

			if (this.hasClassName('moveDown')) {
				adjacentPageItem.insert({
					after: pageItem
				});
			}
			else {
				adjacentPageItem.insert({
					before: pageItem
				});
			}

			if (pageItem.hasClassName('textarea')) {
				tinyMCE.execCommand('mceAddControl', false, pageItem.down('textarea').id);
			}
		}

		GCLMS.PagesController.configureMoveUpAndMoveDownButtons();
	},
	
	confirmDeleteMatchingAnswer: function(event) {
		event.stop();
				
		GCLMS.popup.create({
			text: this.getAttribute('gclms:confirm-text'),
			confirmButtonText: __('Yes'),
			cancelButtonText: __('No'),
			type: 'confirm',
			callback: GCLMS.PagesController.deleteMatchingAnswer.bind(this)
		});
		return false;
	},
	
	deleteMatchingAnswer: function() {
		this.up('div').up('div').remove();
	},
	
	confirmDeleteOrderAnswer: function(event) {
		event.stop();
				
		GCLMS.popup.create({
			text: this.getAttribute('gclms:confirm-text'),
			confirmButtonText: __('Yes'),
			cancelButtonText: __('No'),
			type: 'confirm',
			callback: GCLMS.PagesController.deleteOrderAnswer.bind(this)
		});
		return false;
	},
	
	deleteOrderAnswer: function() {
		this.up('div.order').remove();
	},
	
	confirmDeleteQuestion: function(event) {
		event.stop();
		this.style.color = 'red';
				
		GCLMS.popup.create({
			text: this.getAttribute('gclms:confirm-text'),
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
			text: this.getAttribute('gclms:confirm-text'),
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
		div = this.up('div.gclms-page-item');
		div.select('textarea').each(function(node){
			tinyMCE.execCommand('mceRemoveControl', false, node.id);
		});

		div.remove();
		GCLMS.PagesController.configureMoveUpAndMoveDownButtons();
	},
	
	selectQuestionType: function(event) {
		div = this.up('div');

		/*
		 * 0: Multiple choice
		 * 1: True/false
		 * 2: Matching
		 * 3: Fill in the blank
		 * 4: Essay
		 */

		if(this.value != '0') {
			div.down('.multipleChoice').hide();
			div.down('.question-explanation').displayAsTableRow();
			//tinyMCE.execCommand('mceRemoveControl', false, pageItem.down('textarea').id);
		}

		if(this.value != '1') {
			div.down('.trueFalse').hide();
		}

		if(this.value != '2') {
			div.down('.matching').hide();
			div.down('.matchingHeaders').hide();
		}

		if(this.value != '3') {
			div.down('.order').hide();
		}
		
		if(this.value != '4') {
			div.down('.fillInTheBlank').hide();
		}

		switch(this.value) {
			case '0':
				div.down('.multipleChoice').displayAsTableRow();
				div.down('.question-explanation').hide();
				div.down('.multipleChoice input[type="text"]').focus();
				break;
			case '1':
				div.down('.trueFalse').displayAsTableRow();
				break;
			case '2':
				div.down('.matching').displayAsTableRow();
				div.down('.matchingHeaders').displayAsTableRow();
				div.down('.matchingHeaders input').focus();				
				break;
			case '3':
				div.down('.order').displayAsTableRow();
				div.down('.order input[type="text"]').focus();
				break;
			case '4':
				div.down('.fillInTheBlank').displayAsTableRow();
				div.down('.fillInTheBlank').down('input').focus();
				break;
			case '5':
				break;
		}
	},
	
	addMultipleChoiceAnswer: function(event) {
		div = this.up('div.question');

		answersDiv = div.select('tr.multipleChoice .answers').first();
		answersDiv.insert(GCLMS.Views.get('multipleChoiceAnswer').interpolate({answer_id: UUID.generate(),question_id: div.getAttribute('question:id')}));		
		answersDiv.displayAsBlock();
		lastTable = answersDiv.select('table').last();
		lastTable.observeRules(GCLMS.Triggers.get('.gclms-edit-page')['.gclms-page-item']['tr.multipleChoice,tr.matching']);
		lastTable.parentNode.displayAsBlock();		
		event.stop();

		lastTable.select('input[type="text"]').first().focus();
	},
	
	addMatchingAnswer: function(event) {
		div = this.up('div.question');
		
		answersDiv = div.select('tr.matching .answers').first();
		answersDiv.insert(GCLMS.Views.get('matchingAnswer').interpolate({answer_id: UUID.generate(),question_id: div.getAttribute('question:id')}));
		answersDiv.displayAsBlock();
		lastTable = answersDiv.select('table').last();
		lastTable.observeRules(GCLMS.Triggers.get('.gclms-edit-page')['.gclms-page-item']['tr.multipleChoice,tr.matching']);
		lastTable.parentNode.displayAsBlock();
		event.stop();
		
		lastTable.select('input[type="text"]').first().focus();
	},
	
	addOrderAnswer: function(event) {
		div = this.up('div.question');
		
		answersDiv = div.select('tr.order .answers').first();
		answersDiv.insert(GCLMS.Views.get('orderAnswer').interpolate({answer_id: UUID.generate(),question_id: div.getAttribute('question:id')}));
		answersDiv.displayAsBlock();
		lastTable = answersDiv.select('table').last();
		lastTable.observeRules(GCLMS.Triggers.get('.gclms-edit-page')['.gclms-page-item']['tr.order']);
		lastTable.parentNode.displayAsBlock();
		event.stop();
		
		GCLMS.PagesController.createSortablesForOrderQuestion(div);
		lastTable.select('input[type="text"]').first().focus();		
	},
	
	createSortablesForOrderQuestion: function(div) {
		Sortable.create(div.down('tr.order div.answers').getAttribute('id'),{
			containment: div.down('tr.order div.answers'),
			handle: 'gclms-answer-header',
			tag: 'div',
			scroll: window
		});
	}
};

GCLMS.Triggers.update({
	'.gclms-edit-page' : {
		':loaded': GCLMS.PagesController.loadTextareas,
		'form:submit': GCLMS.PagesController.submitForm,
		'#PageAudioFile,#PageAudioFile:change': GCLMS.PagesController.changePageAudio,
		'.gclms-top-buttons' : {
			'.insertTextarea:click': GCLMS.PagesController.insertTextareaOnTopOfPage,
			'.insertQuestion:click': GCLMS.PagesController.insertQuestionOnTopOfPage
		},

		'.gclms-page-item' : {
			':loaded': 	GCLMS.PagesController.configureMoveUpAndMoveDownButtons,
			'textarea': GCLMS.PagesController.enableTinyMCE,
			'.moveDown:click,.moveUp:click': GCLMS.PagesController.moveItem,
			'.insertTextarea:click': GCLMS.PagesController.insertTextareaBelowPageItem,
			'.insertQuestion:click': GCLMS.PagesController.insertQuestionBelowPageItem,
			'tr.multipleChoice,tr.matching' : {
				'img.deleteAnswer:click': GCLMS.PagesController.confirmDeleteMatchingAnswer,
				'tr.answer-explanation img.addTinyMCEBox:click' : GCLMS.PagesController.addExplanationToMultipleChoiceAnswer
			},
			'tr.order' : {
				'img.add:click': GCLMS.PagesController.addOrderAnswer,
				'img.deleteAnswer:click': GCLMS.PagesController.confirmDeleteOrderAnswer
			},	
			'img.deleteQuestion:click':GCLMS.PagesController.confirmDeleteQuestion,
			'img.deleteTextarea:click':GCLMS.PagesController.confirmDeleteTextarea,
			'input[type="radio"].questionType:click': GCLMS.PagesController.selectQuestionType,
			'.multipleChoice img.add:click': GCLMS.PagesController.addMultipleChoiceAnswer,
			'.matching img.add:click':GCLMS.PagesController.addMatchingAnswer,
			'tr.question-explanation img.addTinyMCEBox:click': GCLMS.PagesController.addExplanationToQuestion
		}
	}
});