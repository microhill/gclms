/*global gclms, Effect, $A, $F, __ */

gclms.SelfCheckController = {
   checkMultipleChoiceSingleSelectionQuestion: function(event){
        event.stop();
        var li = event.findElement('li');
        
        if (li.getAttribute('gclms:attempted')) {
            return false;
        }
        else {
            li.setAttribute('gclms:attempted', true);
        }
        
        var div = this.up('div.gclms-multiple-choice');
        var correct_answers = div.getAttribute('gclms:correct-answers').evalJSON();
        
        var explanation = li.down('.gclms-explanation');
        explanation.displayAsBlock();
        
        var answerStatus = li.down('.gclms-answer-status');
        var answerStatusSpan = answerStatus.down('span');
        
        if (correct_answers.in_array(li.getAttribute('gclms:answer-id'))) {
            answerStatusSpan.innerHTML = __('Correct!');
        }
        else {
            var triesRemaining = parseInt(div.getAttribute('gclms:tries-remaining'), 10);
            if (triesRemaining > 0) {
                div.setAttribute('gclms:tries-remaining', triesRemaining - 1);
                answerStatusSpan.innerHTML = __('Incorrect. Try again.');
            }
            else {
                answerStatusSpan.innerHTML = __('You are out of tries. The correct answer is shown.');
                var correctAnswer = div.down('li[gclms:answer-id="' + correct_answers[0] + '"]');
                correctAnswer.checked = true;
                correctAnswer.down('.gclms-explanation').displayAsBlock();
            }
        }
        answerStatus.displayAsBlock();
        var effect = new Effect.Highlight(answerStatusSpan, {
            endcolor: '#f6f6f6',
            restorecolor: '#f6f6f6'
        });
    },
	
   checkMultipleChoiceMultipleSelectionQuestion: function(event){
        event.stop();
        var div = this.up('div.gclms-multiple-choice');
        var correct_answers = div.getAttribute('gclms:correct-answers').evalJSON();
        var completelyCorrect = true;
        var atLeastPartiallyCorrect = false;
        var answerStatus = div.down('.gclms-answer-status');
        var answerStatusSpan = answerStatus.down('span');
        
        div.select('input').each(function(input){
            if (input.checked) {
                if (correct_answers.in_array(input.getAttribute('gclms:answer-id'))) {
                    atLeastPartiallyCorrect = true;
                }
                else {
                    completelyCorrect = false;
                }
            }
            else 
                if (correct_answers.in_array(input.getAttribute('gclms:answer-id'))) {
                    completelyCorrect = false;
                }
        });
        
        if (completelyCorrect) {
            div.down('.gclms-explanation').displayAsBlock();
            answerStatusSpan.innerHTML = __('Correct!');
            this.up('.gclms-buttons').remove();
        }
        else 
            if (parseInt(div.getAttribute('gclms:tries-remaining'), 10) > 0) {
                div.setAttribute('gclms:tries-remaining', parseInt(div.getAttribute('gclms:tries-remaining'), 10) - 1);
                if (atLeastPartiallyCorrect) {
                    answerStatusSpan.innerHTML = __('You are partially correct. Try again.');
                }
                else {
                    answerStatusSpan.innerHTML = __('Incorrect. Try again.');
                }
            }
            else {
                //Set to correct answers
                div.select('input').each(function(input){
                    if (correct_answers.in_array(input.getAttribute('gclms:answer-id'))) {
                        input.checked = true;
                    }
                    else {
                        input.checked = false;
                        input.removeAttribute('checked');
                    }
                });
                answerStatusSpan.innerHTML = __('You are out of tries. The correct answer is shown.');
                div.down('.gclms-explanation').displayAsBlock();
                this.up('.gclms-buttons').remove();
            }
        
        answerStatus.displayAsBlock();
        var effect = new Effect.Highlight(answerStatusSpan, {
            endcolor: '#f6f6f6',
            restorecolor: '#f6f6f6'
        });
    },
    checkMatchingQuestion: function(event){
        event.stop();
        var div = this.up('div.gclms-matching');
        //var correct_answers = div.down('.gclms-correct-answers-json').innerHTML.evalJSON();
        var completelyCorrect = true;
        var atLeastPartiallyCorrect = false;
        
        var answerStatus = div.down('.gclms-answer-status');
        var answerStatusSpan = answerStatus.down('span');
        
        div.select('.gclms-droppable').each(function(node){
        
            if (node.getAttribute('gclms:attempted-answer-id') != node.getAttribute('correctanswer:id')) {
                completelyCorrect = false;
            }
            else {
                var atLeastPartiallyCorrect = true;
            }
        });
        
        if (completelyCorrect) {
            answerStatusSpan.innerHTML = __('Correct!');
            div.down('.gclms-explanation').displayAsBlock();
            this.up('.gclms-buttons').remove();
        }
        else 
            if (parseInt(div.getAttribute('gclms:tries-remaining'), 10) > 0) {
                div.setAttribute('gclms:tries-remaining', parseInt(div.getAttribute('gclms:tries-remaining'), 10) - 1);
                if (atLeastPartiallyCorrect) {
                    answerStatusSpan.innerHTML = __('You are partially correct. Try again.');
                }
                else {
                    answerStatusSpan.innerHTML = __('Incorrect. Try again.');
                }
            }
            else {
                //Set to correct answers
                
                div.select('.gclms-droppable').each(function(node){
                    var id = node.getAttribute('correctAnswer:id');
                    
                    var draggableElement = div.select('div.gclms-draggable[gclms:answer-id="' + id + '"]').first();
                    
                    node.className = 'gclms-droppable ' + $A(draggableElement.classNames())[1];
                    node.innerHTML = draggableElement.innerHTML;
                    node.setAttribute('gclms:attempted-answer-id', draggableElement.getAttribute('gclms:answer-id'));
                });
                
                answerStatusSpan.innerHTML = __('You are out of tries. The correct answer is shown.');
                div.down('.gclms-explanation').displayAsBlock();
                this.up('.gclms-buttons').remove();
            }
        
        answerStatus.displayAsBlock();
        var effect = new Effect.Highlight(answerStatusSpan, {
            endcolor: '#f6f6f6',
            restorecolor: '#f6f6f6'
        });
    },
	    
    checkFillInTheBlankQuestion: function(event){
        event.stop();
        var div = this.up('div.gclms-fill-in-the-blank');
        var correctAnswers = div.getAttribute('gclms:correct-answers').evalJSON();
        var filteredCorrectAnswers = correctAnswers.walk(function(i){
            return i.strip().toLowerCase();
        });
        var input = div.down('input');
        if ($F(input).empty()) {
            return false;
        }
        var answerStatus = div.down('.gclms-answer-status');
        var answerStatusSpan = answerStatus.down('span');
        
        if (filteredCorrectAnswers.in_array(input.value.strip().toLowerCase())) {
            div.down('.gclms-explanation').displayAsBlock();
            this.up('.gclms-buttons').remove();
            answerStatusSpan.innerHTML = __('Correct!');
        }
        else 
            if (parseInt(div.getAttribute('gclms:tries-remaining'), 10) > 0) {
                answerStatusSpan.innerHTML = __('Incorrect. Try again.');
                div.setAttribute('gclms:tries-remaining', parseInt(div.getAttribute('gclms:tries-remaining'), 10) - 1);
            }
            else {
                input.value = correctAnswers[0];
                this.up('.gclms-buttons').remove();
                answerStatusSpan.innerHTML = __('You are out of tries. The correct answer is shown.');
				div.down('.gclms-explanation').displayAsBlock();
            }
        answerStatus.displayAsBlock();
        var effect = new Effect.Highlight(answerStatusSpan, {
            endcolor: '#f6f6f6',
            restorecolor: '#f6f6f6'
        });
    },
	
    checkOrderQuestion: function(event){
        event.stop();
        var div = this.up('div.gclms-order-question');
        
        var answers = div.getAttribute('gclms:correct-answer').evalJSON();
        var order = 0;
        var correct = true;
        
        var answerStatus = div.down('.gclms-answer-status');
        var answerStatusSpan = answerStatus.down('span');
        
        div.select('.gclms-answers > li').each(function(li){
            if (li.getAttribute('gclms:answer-id') != answers[order]) {
                correct = false;
                return false;
            }
            order++;
        });
        if (correct) {
            this.up('.gclms-buttons').remove();
            answerStatusSpan.innerHTML = __('Correct!');
            div.down('.gclms-explanation').displayAsBlock();
        }
        else {
            var triesRemaining = parseInt(div.getAttribute('gclms:tries-remaining'), 10);
            if (triesRemaining > 0) {
                div.setAttribute('gclms:tries-remaining', triesRemaining - 1);
                answerStatusSpan.innerHTML = __('Incorrect. Try again.');
            }
            else {
                answerStatusSpan.innerHTML = __('You are out of tries. The correct answer is shown.');
                this.up('.gclms-buttons').remove();
                // reorder items
                answers.each(function(answer){
                    div.down('ul.gclms-answers').insert(div.down('li[gclms:answer-id="' + answer + '"]'));
                });
                div.down('.gclms-explanation').displayAsBlock();
            }
        }
        
        answerStatus.displayAsBlock();
        var effect = new Effect.Highlight(answerStatusSpan, {
            endcolor: '#f6f6f6',
            restorecolor: '#f6f6f6'
        });
    },
    
    checkTrueFalseQuestion: function(event){
        event.stop();
        var div = this.up('div.gclms-true-false');
        var correctAnswer = div.getAttribute('gclms:correct-answer');
        var answerStatus = div.down('.gclms-answer-status');
        var answerStatusSpan = answerStatus.down('span');
        
        if (this.getAttribute('gclms:answer-value') == correctAnswer) {
            if (correctAnswer == "0") {
                answerStatusSpan.innerHTML = __('Correct! The correct answer is false.');
            }
            else {
                answerStatusSpan.innerHTML = __('Correct! The correct answer is true.');
            }
        }
        else {
            if (correctAnswer == "0") {
                answerStatusSpan.innerHTML = __('Incorrect. The correct answer is false.');
            }
            else {
                answerStatusSpan.innerHTML = __('Incorrect. The correct answer is true.');
            }
        }
        this.up('.gclms-buttons').remove();
        answerStatus.displayAsBlock();
        div.down('.gclms-explanation').displayAsBlock();
        var effect = new Effect.Highlight(answerStatusSpan, {
            endcolor: '#f6f6f6',
            restorecolor: '#f6f6f6'
        });
    },
	
    checkEssayQuestion: function(event){
        event.stop();
        this.up('div.gclms-essay-question').down('.gclms-explanation').displayAsBlock();
        this.up('div.gclms-buttons').remove();
    },
	
	saveEssayQuestion: function(event) {
		event.stop();
		var question = this.up('.gclms-essay-question');
		gclms.QuestionResponse.save({
			questionId: question.getAttribute('gclms:question-id'),
			answer: tinyMCE.get(question.down('textarea').id).getContent(),
			callback: function(transport) {
				//document.body.insert(transport.responseText);
			}
		});
	}
};

gclms.QuestionResponse = {
	ajaxUrl: '/' + document.body.getAttribute('gclms-group') + '/' + document.body.getAttribute('gclms-course') + '/question_responses/',
	save: function(options){
		var request = new Ajax.Request(this.ajaxUrl + 'save_essay', {
			method: 'post',
			parameters: {
				'data[QuestionResponse][question_id]': options.questionId,
				'data[QuestionResponse][answer]': options.answer			
			},
			onComplete: options.callback
		});
	}
}

gclms.Triggers.update({
    '.gclms-multiple-choice': {
        'input[type="radio"]:change': gclms.SelfCheckController.checkMultipleChoiceSingleSelectionQuestion,
        '.gclms-button.gclms-check-answer-button:click': gclms.SelfCheckController.checkMultipleChoiceMultipleSelectionQuestion
    },
    '.gclms-matching': {
        '.gclms-button.gclms-check-answer-button:click': gclms.SelfCheckController.checkMatchingQuestion,
        'div.gclms-draggable': gclms.PageController.createMatchingDraggables,
        'div.gclms-droppable': gclms.PageController.createMatchingDroppables
    },
    '.gclms-fill-in-the-blank': {
        'input:keyup': gclms.PageController.expandFillInTheBlankField,
        '.gclms-button.gclms-check-answer-button:click': gclms.SelfCheckController.checkFillInTheBlankQuestion
    },
    '.gclms-order-question': {
        'ul': gclms.SelfCheckController.createOrderSortable,
        '.gclms-button.gclms-check-answer-button:click': gclms.SelfCheckController.checkOrderQuestion
    },
    '.gclms-essay-question': {
		'.gclms-button.gclms-check-answer-button a:click': gclms.SelfCheckController.checkEssayQuestion,
		'.gclms-button.gclms-save-answer-button a:click': gclms.SelfCheckController.saveEssayQuestion
	},
    '.gclms-true-false .gclms-button.gclms-check-answer-button:click': gclms.SelfCheckController.checkTrueFalseQuestion
});