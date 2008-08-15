/*global $, $$, $F, Ajax, Element, GCLMS, Sortable, document, window, tinyMCE, self, UUID, __, tmpTextareaView, tmpQuestionView, tmpQuestionExplanationView, tmpMultipleChoiceAnswerView, tmpMultipleChoiceAnswerExplanationView, tmpMatchingAnswerView, tmpOrderAnswerView */

GCLMS.PagesController = {
	addExplanationToQuestion: function() {
		var question = this.up('div.gclms-question');
		var questionId = question.getAttribute('question:id');
		
		this.replace(GCLMS.Views.get('questionExplanation').interpolate({id: questionId}));
		
		GCLMS.PagesController.enableAdvancedTinyMCE.bind(question.down('textarea.gclms-question-explanation'))();
		question.down('tr.gclms-question-explanation td').addClassName('gclms-filled');
	},
	
	addExplanationToMultipleChoiceAnswer: function() {
		var questionDiv = this.up('div.gclms-question');
		var questionId = questionDiv.getAttribute('question:id');
		
		var div = this.up('div.gclms-multiple-choice');
		var answerId = div.getAttribute('gclms:answer-id');
		this.replace(GCLMS.Views.get('multipleChoiceAnswerExplanation').interpolate({answer_id: answerId,question_id: questionId}));
		
		GCLMS.advancedTinyMCEConfig.height = '75px';
		GCLMS.PagesController.enableAdvancedTinyMCE.bind(div.down('textarea.gclms-answer-explanation'))();
		div.down('tr.gclms-answer-explanation td').addClassName('gclms-filled');
	},
	
	toggleTinyMCE: function () {
		if(tinyMCE.get(this.id)) {
			tinyMCE.execCommand('mceToggleEditor', true, this.id);	
		}
	},
	
	removeTinyMCE: function () {
		if(tinyMCE.get(this.id)) {
			tinyMCE.execCommand('mceRemoveControl', true, this.id);			
		}
	},

	enableAdvancedTinyMCE: function() {
		tinyMCE.settings = GCLMS.advancedTinyMCEConfig;
		if(tinyMCE.get(this.id)) {
			tinyMCE.execCommand('mceToggleEditor', true, this.id);			
		} else {
			tinyMCE.execCommand('mceAddControl', true, this.id);
		}
		//GCLMS.advancedTinyMCEConfig.height = '250px';
	},
	
	enableSimpleTinyMCE: function() {		
		tinyMCE.settings = GCLMS.simpleTinyMCEConfig;
		if(tinyMCE.get(this.id)) {
			tinyMCE.execCommand('mceToggleEditor', true, this.id);			
		} else {
			tinyMCE.execCommand('mceAddControl', true, this.id);
		}
	},

	configureMoveUpAndMoveDownButtons: function() {
		$$('img.gclms-move-up[disabled="disabled"],img.gclms-move-down[disabled="disabled"]').each(function(node){node.removeAttribute('disabled');});
		var moveUpButtons = $$('img.gclms-move-up');
		if (!moveUpButtons.first()) {
			return true;
		}
		moveUpButtons.first().setAttribute('disabled','disabled');
		$$('img.gclms-move-down').last().setAttribute('disabled','disabled');
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
		div.next('div.gclms-page-item').observeRules(GCLMS.Triggers.get('.gclms-edit-page')['.gclms-textarea']);
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
		nextDiv.observeRules(GCLMS.Triggers.get('.gclms-edit-page')['.gclms-question']);
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
			if(node.hasClassName('gclms-textarea')) {
				id = node.getAttribute('textarea:id');
				var type = 'Textarea';
			} else {
				id = node.getAttribute('question:id');
				var type = 'Question';
			}

			try {
				this.insert(new Element('input', {
					name: 'data[' + type + '][' + id + '][order]',
					value: ++order,
					type: 'hidden'
				}));
			} catch(error) {
				alert(error);
			}
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
		var pageItem = this.up('div.gclms-page-item');

		if (this.hasClassName('gclms-move-down') && !(adjacentPageItem = pageItem.next('div.gclms-page-item'))) {
			return false;
		} else if (this.hasClassName('gclms-move-up') && !(adjacentPageItem = pageItem.previous('div.gclms-page-item'))) {
			return false;
		}

		adjacentPageItem.select('textarea').each(function(textarea) {
			GCLMS.PagesController.removeTinyMCE.bind(textarea)();
			//tinyMCE.execCommand('mceRemoveControl', false, textarea.id);
		});

		if (this.hasClassName('gclms-move-down')) {
			pageItem.insert({
				before: adjacentPageItem
			});
		} else {
			pageItem.insert({
				after: adjacentPageItem
			});
		}
		
		adjacentPageItem.select('textarea').each(function(textarea) {
			if(textarea.hasClassName('gclms-simple-tinymce-enabled')) {
				GCLMS.PagesController.enableSimpleTinyMCE.bind(textarea)();
			} else {
				GCLMS.PagesController.enableAdvancedTinyMCE.bind(textarea)();
			}
		});

		GCLMS.PagesController.configureMoveUpAndMoveDownButtons();
	},
	
	confirmDeleteAnswer: function(event) {
		event.stop();
				
		GCLMS.popup.create({
			text: this.getAttribute('gclms:confirm-text'),
			confirmButtonText: __('Yes'),
			cancelButtonText: __('No'),
			type: 'confirm',
			callback: GCLMS.PagesController.deleteAnswer.bind(this)
		});
		return false;
	},
	
	deleteAnswer: function() {
		div = this.up('div').up('div');
		div.select('textarea').each(function(textarea){
			GCLMS.PagesController.removeTinyMCE.bind(textarea)();
			//tinyMCE.execCommand('mceRemoveControl', false, textarea.id);
		});
		div.remove();
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
		this.up('div.gclms-order').remove();
	},
	
	confirmDeleteQuestion: function(event) {
		event.stop();
		this.style.color = 'red';
				
		GCLMS.popup.create({
			text: this.getAttribute('gclms:confirm-text'),
			confirmButtonText: __('Yes'),
			cancelButtonText: __('No'),
			type: 'confirm',
			callback: GCLMS.PagesController.deletePageItem.bind(this),
			cancelCallback: function(){
				this.style.color = '';
			}.bind(this)
		});
		return false;
	},
	
	deletePageItem: function() {
		div = this.up('div.gclms-page-item');
		div.select('textarea').each(function(textarea){
			GCLMS.PagesController.removeTinyMCE.bind(textarea)();
		});
		div.remove();
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
			callback: GCLMS.PagesController.deletePageItem.bind(this),
			cancelCallback: function(){
				this.style.color = '';
			}.bind(this)
		});
		return false;
	},
	
	/*
	deleteTextarea: function() {
		div = this.up('div.gclms-page-item');
		div.select('textarea').each(function(node){
			tinyMCE.execCommand('mceRemoveControl', false, node.id);
		});

		div.remove();
		GCLMS.PagesController.configureMoveUpAndMoveDownButtons();
	},
	*/
	
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
			div.down('.gclms-multiple-choice').hide();
			div.down('.gclms-question-explanation').displayAsTableRow();
			//tinyMCE.execCommand('mceRemoveControl', false, pageItem.down('textarea').id);
		}

		if(this.value != '1') {
			div.down('.gclms-true-false').hide();
		}

		if(this.value != '2') {
			div.down('.gclms-matching').hide();
			div.down('.gclms-matching-headers').hide();
		}

		if(this.value != '3' && this.value != '4') {
			div.down('.gclms-order').hide();
		}

		switch(this.value) {
			case '0':
				div.down('.gclms-multiple-choice').displayAsTableRow();
				div.down('.gclms-question-explanation').hide();
				try{div.down('.gclms-multiple-choice input[type="text"]').focus();}catch(e){}
				break;
			case '1':
				div.down('.gclms-true-false').displayAsTableRow();
				break;
			case '2':
				div.down('.gclms-matching').displayAsTableRow();
				div.down('.gclms-matching-headers').displayAsTableRow();
				div.down('.gclms-matching-headers input').focus();				
				break;
			case '3':
				div.down('.gclms-order').displayAsTableRow();
				try{div.down('.gclms-order input[type="text"]').focus();}catch(e){}
				break;
			case '4':
				div.down('.gclms-order').displayAsTableRow();
				try{div.down('.gclms-order input[type="text"]').focus();}catch(e){}
				break;
			case '5':
				break;
		}
	},
	
	addMultipleChoiceAnswer: function(event) {
		var div = this.up('div.gclms-question');

		answersDiv = div.select('tr.gclms-multiple-choice .gclms-answers').first();
		answersDiv.insert(GCLMS.Views.get('multipleChoiceAnswer').interpolate({answer_id: UUID.generate(),question_id: div.getAttribute('question:id')}));		
		answersDiv.displayAsBlock();
		lastTable = answersDiv.select('table').last();
		lastTable.observeRules(GCLMS.Triggers.get('.gclms-edit-page')['.gclms-question']['.gclms-multiple-choice']['.gclms-answer']);
		lastTable.parentNode.displayAsBlock();		
		event.stop();

		tinyMCE.execCommand('mceFocus',false,lastTable.select('textarea').first().id); 
	},
	
	addMatchingAnswer: function(event) {
		div = this.up('div.gclms-question');
		
		answersDiv = div.select('tr.gclms-matching .gclms-answers').first();
		answersDiv.insert(GCLMS.Views.get('matchingAnswer').interpolate({answer_id: UUID.generate(),question_id: div.getAttribute('question:id')}));
		answersDiv.displayAsBlock();
		lastTable = answersDiv.select('table').last();
		lastTable.observeRules(GCLMS.Triggers.get('.gclms-edit-page')['.gclms-question']['tr.gclms-matching']);
		lastTable.parentNode.displayAsBlock();
		event.stop();
		
		lastTable.select('input[type="text"]').first().focus();
	},
	
	addOrderAnswer: function(event) {
		div = this.up('div.gclms-question');
		
		answersDiv = div.select('tr.gclms-order .gclms-answers').first();
		answersDiv.insert(GCLMS.Views.get('orderAnswer').interpolate({answer_id: UUID.generate(),question_id: div.getAttribute('question:id')}));
		answersDiv.displayAsBlock();
		lastTable = answersDiv.select('table').last();
		lastTable.observeRules(GCLMS.Triggers.get('.gclms-edit-page')['.gclms-page-item']['tr.gclms-order']);
		lastTable.parentNode.displayAsBlock();
		event.stop();
		
		GCLMS.PagesController.createSortablesForOrderQuestion.bind(div.down('tr.gclms-order div.gclms-answers'))();
		lastTable.select('input[type="text"]').first().focus();		
	},
	
	createSortablesForOrderQuestion: function() {
		Sortable.create(this.getAttribute('id'),{
			containment: this,
			handle: 'gclms-answer-header',
			tag: 'div',
			scroll: window
		});
	},
	
	// If more than answer is correct, then use general question-explanation
	toggleMultipleChoiceCorrectAnswer: function() {
		var question = this.up('div.gclms-question');
		var totalCorrectAnswers = 0
		question.select('input.gclms-multiple-choice-answer-correct').each(function(checkbox){
			if(checkbox.checked) {
				totalCorrectAnswers++;
			}
		});

		var questionExplanation = question.down('.gclms-question-explanation');
		var previousTotalCorrectAnswers = parseInt(question.getAttribute('gclms:total-correct'));
		if(totalCorrectAnswers == 1 && (previousTotalCorrectAnswers == 2)) {
			/*
			GCLMS.popup.create({
				text: 'Multiple choice questions which have only one correct answer have an explanation for each possible selection.',
				cancelButtonText: null,
				type: 'alert'
			})*/
			// Put question-explanation into first answer-explanation
			questionExplanationTextarea = questionExplanation.down('textarea');
			
			question.select('tr.gclms-answer-explanation').each(function(tr) {
				var textarea = tr.down('textarea');
				if (textarea) {
					GCLMS.advancedTinyMCEConfig.height = '75px';
					tr.down('td').addClassName('gclms-filled');
					GCLMS.PagesController.enableAdvancedTinyMCE.bind(textarea)();
				}
				tr.displayAsTableRow();
			});

			if(questionExplanationTextarea) {
				var firstTextarea = question.down('tr.gclms-answer-explanation textarea');
				if(firstTextarea) {
					var explanation = tinyMCE.get(questionExplanationTextarea.id).getContent();
					tinyMCE.get(firstTextarea.id).setContent(explanation);
				}
			}
			questionExplanation.hide();
		} else if(totalCorrectAnswers > 1 && previousTotalCorrectAnswers == 1) {
			/*
			GCLMS.popup.create({
				text: 'Multiple choice questions which require selection of multiple answers have an accumulative explanation instead of one per answer.',
				cancelButtonText: null,
				type: 'alert'
			});
			*/
			var newExplanation = '';
			question.select('tr.gclms-answer-explanation').each(function(tr) {
				var textarea;
				if (textarea = tr.down('textarea')) {
					newExplanation += tinyMCE.get(textarea.id).getContent();
					tinyMCE.execCommand('mceToggleEditor', false, textarea.id);
				}
				tr.hide();
			});
			// Accumulate individual explanations into overarching one
			questionExplanation.displayAsTableRow();
			if(!questionExplanation.select('textarea').length) {				
				questionExplanation.down('img').replace(GCLMS.Views.get('questionExplanation').interpolate({id: question.getAttribute('question:id')}));
				questionExplanation.down('textarea').innerHTML = newExplanation;
				GCLMS.PagesController.enableAdvancedTinyMCE.bind(question.down('textarea.gclms-question-explanation'))();
				questionExplanation.down('td').addClassName('gclms-filled');
			} else {
				tinyMCE.get(questionExplanation.down('textarea').id).setContent(newExplanation);
			}
		}
		question.setAttribute('gclms:total-correct',totalCorrectAnswers);
	}
};

GCLMS.Triggers.update({
	'.gclms-edit-page' : {
		':loaded': GCLMS.PagesController.loadTextareas,
		'form': function() {
			this.observe('gclms:submit',GCLMS.PagesController.submitForm);
		},		
		//GCLMS.PagesController.submitForm,
		'#PageAudioFile,#PageAudioFile:change': GCLMS.PagesController.changePageAudio,
		'.gclms-top-buttons' : {
			'.gclms-insert-textarea:click': GCLMS.PagesController.insertTextareaOnTopOfPage,
			'.gclms-insert-question:click': GCLMS.PagesController.insertQuestionOnTopOfPage
		},
		'.gclms-page-item': {
			':loaded': 	GCLMS.PagesController.configureMoveUpAndMoveDownButtons,
			'.gclms-move-down:click,.gclms-move-up:click': GCLMS.PagesController.moveItem,
			'.gclms-insert-textarea:click': GCLMS.PagesController.insertTextareaBelowPageItem,
			'.gclms-insert-question:click': GCLMS.PagesController.insertQuestionBelowPageItem
		},
		'.gclms-textarea': {
			'img.gclms-delete-textarea:click':GCLMS.PagesController.confirmDeleteTextarea,
			'textarea.gclms-tinymce-enabled': GCLMS.PagesController.enableAdvancedTinyMCE
		},
		'.gclms-question': {
			'input[type="radio"].gclms-question-type:click': GCLMS.PagesController.selectQuestionType,
			'textarea.gclms-simple-tinymce-enabled.gclms-question-title': GCLMS.PagesController.enableSimpleTinyMCE,
			'textarea.gclms-question-explanation': GCLMS.PagesController.enableAdvancedTinyMCE,
			'img.gclms-delete-question:click':GCLMS.PagesController.confirmDeleteQuestion,
			'.gclms-multiple-choice': {
				'.gclms-answer': {
					'tr.gclms-answer-explanation img.gclms-add-tinymce-box:click' : GCLMS.PagesController.addExplanationToMultipleChoiceAnswer,
					'img.gclms-delete-answer:click': GCLMS.PagesController.confirmDeleteAnswer,
					'input.gclms-multiple-choice-answer-correct:change': GCLMS.PagesController.toggleMultipleChoiceCorrectAnswer,
					'textarea.gclms-simple-tinymce-enabled': GCLMS.PagesController.enableSimpleTinyMCE	
				},
				'img.gclms-add:click': GCLMS.PagesController.addMultipleChoiceAnswer
			},
			'.gclms-matching': {
				'img.gclms-delete-answer:click': GCLMS.PagesController.confirmDeleteAnswer,
				'img.gclms-add:click':GCLMS.PagesController.addMatchingAnswer
			},
			'tr.gclms-order' : {
				'img.gclms-add:click': GCLMS.PagesController.addOrderAnswer,
				'img.gclms-delete-answer:click': GCLMS.PagesController.confirmDeleteOrderAnswer,
				'div.gclms-answers': GCLMS.PagesController.createSortablesForOrderQuestion
			},
			'tr.gclms-question-explanation img.gclms-add-tinymce-box:click': GCLMS.PagesController.addExplanationToQuestion
		}
	}
});