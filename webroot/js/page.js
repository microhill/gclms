/* global $, $$, Ajax, Element, GCLMS, Sortable, document, window, self, UUID, __ */

GCLMS.PageController = {
	createOrderSortable: function(event) {
		Sortable.create(this.getAttribute('id'),{
			containment: this,
			scroll: window
		});
	},
	
	checkMultipleChoiceQuestion1: function(event) {
		li = event.findElement('li');
		event.stop();
		
		if(li.getAttribute('gclms:attempted')) {
			return false;
		} else {
			li.setAttribute('gclms:attempted',true);
		}
		
		var div = this.up('div.gclms-multiple-choice');
		var correct_answers = div.getAttribute('gclms:correct-answers').evalJSON();
		
		var explanation = li.down('.gclms-explanation');
		explanation.displayAsBlock();
		
		if(correct_answers.in_array(li.getAttribute('gclms:answer-id'))) {
			explanation.insert({top:'<p class="gclms-correct-answer">' + __('Correct!') + '</p>'});
		} else {
			var triesRemaining = parseInt(div.getAttribute('gclms:tries-remaining'),10);
			if(triesRemaining > 0) {
				div.setAttribute('gclms:tries-remaining',triesRemaining - 1);
				explanation.insert({top:'<p class="gclms-correct-answer">' + __('Incorrect. Try again.') + '</p>'});
			} else {
				explanation.insert({top:'<p class="gclms-correct-answer">' + __('You are out of tries. The correct answer is shown.') + '</p>'});
				var correctAnswer = div.down('li[gclms:answer-id="' + correct_answers[0] + '"]');
				correctAnswer.checked = true;
				correctAnswer.down('.gclms-explanation').displayAsBlock();
			}
		}
	},
	
	checkMultipleChoiceQuestion: function(event) {
		alert(1);
		div = event.findElement('div');
		completelyCorrect = true;
		atLeastPartiallyCorrect = false;

		$A(div.select('input')).each(function(node) {
			if(node.checked) {
				if(node.getAttribute('gclms:answer-correct') == 'true') {
					atLeastPartiallyCorrect = true;
				} else {
					completelyCorrect = false;
				}
			} else {
				if(node.getAttribute('gclms:answer-correct') == 'true') {
					completelyCorrect = false;
				}
			}
		});

		if(completelyCorrect) {
			alert(div.getAttribute('gclms:question-defaultCorrectMessage'));
		} else if(parseInt(div.getAttribute('gclms:question-tries-remaining'),10) > 0) {
			div.setAttribute('gclms:question-tries-remaining',parseInt(div.getAttribute('gclms:question-tries-remaining'),10) - 1);
			if(atLeastPartiallyCorrect) {
				alert(div.getAttribute('gclms:question-defaultPartiallyCorrectMessage'));
			} else {
				alert(div.getAttribute('gclms:question-defaultTryAgainMessage'));
			}
		} else {
			//Set to correct answers
			div.select('input').each(function(node) {
				if(node.getAttribute('gclms:answer-correct') == 'true') {
					node.checked = true;
				} else if(node.getAttribute('gclms:answer-correct') == 'false') {
					node.checked = false;
					node.removeAttribute('checked');
				}
			});
			alert(div.getAttribute('gclms:question-defaultNoMoreIncorrectTriesMessage'));
		}

		event.stop();
	},
	checkMatchingQuestion: function(event) {
		div = $(event.findElement('div'));
		completelyCorrect = true;
		atLeastPartiallyCorrect = false;

		div.select('.gclms-droppable').each(function(node){
			if (node.getAttribute('attemptedAnswer:id') != node.getAttribute('correctAnswer:id')) {
				completelyCorrect = false;
			} else {
				atLeastPartiallyCorrect = true;
			}
		});

		if(completelyCorrect) {
			alert(div.getAttribute('gclms:question-defaultCorrectMessage'));
		} else if(parseInt(div.getAttribute('gclms:question-tries-remaining'),10) > 0) {
			div.setAttribute('gclms:question-tries-remaining',parseInt(div.getAttribute('gclms:question-tries-remaining'),10) - 1);
			if(atLeastPartiallyCorrect) {
				alert(div.getAttribute('gclms:question-defaultPartiallyCorrectMessage'));
			} else {
				alert(div.getAttribute('gclms:question-defaultTryAgainMessage'));
			}
		} else {
			//Set to correct answers

			div.select('gclms-droppable').each(function(node){
				id = node.getAttribute('correctAnswer:id');

				draggableElement = div.select('div.gclms-draggable[answer:id="' + id + '"]').first();

				node.className = 'gclms-droppable ' + $A(draggableElement.classNames())[1];
				node.innerHTML = draggableElement.innerHTML;
				node.setAttribute('attemptedAnswer:id',draggableElement.getAttribute('gclms:answer-id'));
			});

			alert(div.getAttribute('gclms:question-defaultNoMoreIncorrectTriesMessage'));
		}

		event.stop();
	},
	gradeQuestions: function(event) {
		event.stop();
		totalQuestions = 0;
		totalCorrectAnswers = 0;

		$$('.questions > div').each(function(question){
			totalQuestions++;
			if(question.hasClassName('gclms-multiple-choice')) {
				div = question;
				completelyCorrect = true;
				atLeastPartiallyCorrect = false;

				$A(div.select('input')).each(function(node) {
					if(node.checked) {
						if(node.getAttribute('gclms:answer-correct') == 'true') {
							atLeastPartiallyCorrect = true;
						} else {
							completelyCorrect = false;
						}
					} else {
						if(node.getAttribute('gclms:answer-correct') == 'true') {
							completelyCorrect = false;
						}
					}
				});

				if(completelyCorrect) {
					totalCorrectAnswers++;
					graphic = '<img src="/img/check-22.png" /> ';
					question.style.backgroundColor = '#DBFFDB';
				} else {
					graphic = '<img src="/img/red_x-22.png" /> ';
					question.style.backgroundColor = '#FEE5E2';
				}
				question.select('h3').first().insert({top: graphic});

			} else if(question.hasClassName('matching')) {
				completelyCorrect = true;
				div = question;

				div.select('.gclms-droppable').each(function(node){
					if(node.getAttribute('attemptedAnswer:id') != node.getAttribute('correctAnswer:id')) {
						completelyCorrect = false;
					}
				});

				if(completelyCorrect) {
					totalCorrectAnswers++;
					graphic = '<img src="/img/check-22.png" /> ';
					question.style.backgroundColor = '#DBFFDB';
				} else {
					graphic = '<img src="/img/red_x-22.png" /> ';
					question.style.backgroundColor = '#FEE5E2';
				}
				question.select('h3').first().insert({top: graphic});
			} else if(question.hasClassName('gclms-true-false')) {

			} else if(question.hasClassName('gclms-fill-in-the-blank')) {
				div = question;
				input = div.getElementsByTagName('input').item(0);

				if(input.value.trim().toLowerCase() == input.getAttribute('correctAnswer:text').trim().toLowerCase()) {
					totalCorrectAnswers++;
					graphic = '<img src="/img/check-22.png" /> ';
					question.style.backgroundColor = '#DBFFDB';
				} else {
					graphic = '<img src="/img/red_x-22.png" /> ';
					question.style.backgroundColor = '#FEE5E2';
				}
				question.select('h3').first().insert({top: graphic});
			}
			return false;
		});
		$('gradeResults').update('Submitting grade...');
		var request = new Ajax.Request('/' + document.body.getAttribute('gclms:group') + '/grades/update_assessment/section:' + document.body.getAttribute('section:id') + '/page:' + document.body.getAttribute('page:id') + '/grade:' + totalCorrectAnswers + '/maximum_possible:' + totalQuestions, {
		  onSuccess: function(request) {
			document.body.insert(request.responseText);
			$('gradeResults').update('Your score is ' + totalCorrectAnswers + ' out of ' + totalQuestions + '.');
		  }
		});
	},
	createMatchingDraggables: function(event) {
		var draggable = new Draggable(this,{
			revert:true,
			ghosting:false,
			reverteffect: function(element, top_offset, left_offset){
		        var moveEffect = new Effect.Move(element, { x: -left_offset, y: -top_offset, duration: 0});
			}
		});
	},
	createMatchingDroppables: function(event) {
		Droppables.add(this, {
			containment: $A(this.up('div.gclms-matching').select('td.gclms-draggable-container')),
			onDrop: function(draggableElement, droppableElement) {
				
				// See if answer has already been dropped
				tbody = droppableElement.findParent('tbody');
				
				tbody.select('div.gclms-droppable').each(function(node){
					if(node.getAttribute('attemptedAnswer:id') == this.getAttribute('gclms:answer-id')) {
						node.removeAttribute('attemptedAnswer:id');
						node.innerHTML = '';
						node.className = 'gclms-droppable gclms-default-droppable-color';
					}
				}.bind(draggableElement));

				// Clone answer into droppable container
				droppableElement.className = 'gclms-droppable ' + $A(draggableElement.classNames())[1];
				droppableElement.innerHTML = draggableElement.innerHTML;
				droppableElement.setAttribute('attemptedAnswer:id',draggableElement.getAttribute('gclms:answer-id'));
				// */
			}
		});
	},
	checkFillInTheBlankQuestion: function(event) {
		div = event.findElement('div');
		input = div.getElementsByTagName('input').item(0);

		if(input.value.trim().toLowerCase() == input.getAttribute('correctAnswer:text').trim().toLowerCase()) {
			alert(div.getAttribute('gclms:question-defaultCorrectMessage'));
		} else if(parseInt(div.getAttribute('gclms:question-tries-remaining'),10) > 0) {
			div.setAttribute('gclms:question-tries-remaining',parseInt(div.getAttribute('gclms:question-tries-remaining'),10) - 1);
			alert(div.getAttribute('gclms:question-defaultTryAgainMessage'));
		} else {
			correctAnswer = input.getAttribute('correctAnswer:text').trim();
			$A(div.getElementsByTagName('p')).each(function(node){
				Element.remove(node);
			});
			var tmpInsertion1 = new Insertion.Bottom(div,'<p class="gclms-correct-answer">' + correctAnswer + '</p>');
			alert(div.getAttribute('gclms:question-defaultNoMoreIncorrectTriesMessage'));
		}
	},

	expandFillInTheBlankField: function(event) {
		answerLength = this.value.length;

		if (this.size < answerLength && answerLength < 100 && answerLength > 30) {
			this.size = answerLength;
		}
		else {
			if (this.size > answerLength && this.size > 30) {
				this.size = 30;
			}
		}
	},
	
	checkOrderQuestion: function(event) {
		event.stop();
		var div = this.up('div.gclms-order-question');

		var answers = div.getAttribute('gclms:correct-answer').evalJSON();
		var order = 0;
		var correct = true;
		div.select('.gclms-answers > li').each(function(li) {
			if(li.getAttribute('gclms:answer-id') != answers[order]) {
				correct = false;
				return false;
			}
			order++;
		});
		if(correct) {
			this.up('.gclms-buttons').replace('<p class="gclms-correct-answer">' + __('Correct!') + '</p>');
			div.down('.gclms-explanation').displayAsBlock();
		} else {
			var triesRemaining = parseInt(div.getAttribute('gclms:tries-remaining'),10);
			if(triesRemaining > 0) {
				div.setAttribute('gclms:tries-remaining',triesRemaining - 1);
				GCLMS.popup.create({
					text: __('Incorrect. Try again.'),
					cancelButtonText: null,
					type: 'confirm'
				});
			} else {
				this.up('.gclms-buttons').replace('<p class="gclms-correct-answer">' + __('You are out of tries. The correct answer is shown.') + '</p>');
				// reorder items
				answers.each(function(answer){
					div.down('ul.gclms-answers').insert(div.down('li[gclms:answer-id="' + answer + '"]'));
				});
				div.down('.gclms-explanation').displayAsBlock();
			}
		}
	},

	checkTrueFalseQuestion: function(event) {
		event.stop();
		var div = this.up('div.gclms-true-false');
		var correctAnswer = div.getAttribute('gclms:correct-answer');

		if(this.getAttribute('gclms:answer-value') == correctAnswer) {
			if (correctAnswer == "0") {
				this.up('.gclms-buttons').replace('<p class="gclms-correct-answer">' + __('Correct! The correct answer is false.') + '</p>');
			}
			else {
				this.up('.gclms-buttons').replace('<p class="gclms-correct-answer">' + __('Correct! The correct answer is true.') + '</p>');
			}
		} else {
			if (correctAnswer == "0") {
				this.up('.gclms-buttons').replace('<p class="gclms-correct-answer">' + __('Incorrect. The correct answer is false.') + '</p>');
			}
			else {
				this.up('.gclms-buttons').replace('<p class="gclms-correct-answer">' + __('Incorrect. The correct answer is true.') + '</p>');
			}
		}
		div.down('.gclms-explanation').displayAsBlock();
	},
	loadBibleVerse: function(event) {
		top.Ext.getCmp('bibleViewport').expand();
		//if (!top.$('bibleViewportContent').contentDocument.body.innerHTML) {
			top.$('bibleViewportContent').src = this.getAttribute('href');
		//}
		event.stop();
	},

	loadChapter: function(event) {
		var url = this.getAttribute('href').split('chapters/view/');

		top.Ext.getCmp('booksViewport').expand();
		top.$('booksViewportContent').src = GCLMS.urlPrefix + 'chapters/view/' + url[1] + '?framed';
		event.stop();
	},
	
	loadArticle: function(event) {
		var url = this.getAttribute('href').split('articles/view/');

		top.Ext.getCmp('articlesViewport').expand();
		top.$('articlesViewportContent').src = GCLMS.urlPrefix + 'articles/view/' + url[1] + '?framed';
		event.stop();
	},
	
	loadGlossaryTerm: function(event) {
		var url = this.getAttribute('href').split('glossary/view/');

		top.Ext.getCmp('glossaryViewport').expand();
		//if (!top.$('glossaryViewportContent').contentDocument.body.innerHTML) {
		top.$('glossaryViewportContent').src = GCLMS.urlPrefix + 'glossary/view/' + url[1] + '?framed';
		event.stop();
	},
	
	loadNotebook: function() {
		parent.Ext.getCmp('classroomTabs').activate('notebookTab');
	},
	
	loadPageAudio: function() {
		mp3Player = $$('div.gclms-mp3-player')[0];
		
		if(window.soundManager !== undefined && mp3Player) {
			soundManager.useConsole = false;
			soundManager.debugMode = false;
		
			soundManager.createMovie('/js/vendors/sound_manager/soundmanager2.swf');
		
			mp3Player.insert(new Element('div', {className: 'gclms-play'}));
			mp3Player.insert(new Element('div', {className: 'gclms-blank-track'}));
			mp3Player.insert(new Element('div', {className: 'gclms-progress-track'}));
			mp3Player.insert(new Element('div', {className: 'gclms-transparent-track'}).insert(
					new Element('div', {className: 'handle'})
			));
		
			soundManager.onload = function(){
				$$('div.mp3player').each(function(node){
					var MP3PlayerObject = new MP3Player(node);
				});
			};
		}
	},
	
	gotoPageLink: function(event) {
		location.href = this.getAttribute('href') + '?framed';		
		event.stop();
	},
	
	highlightCurrentPage: function() {
		try {
			top.GCLMS.ClassroomController.highlightCurrentPage(location.href);
		} catch(e){};
	}
}

GCLMS.Triggers.update({
	//'div.gclms-page': GCLMS.PageController.loadPageAudio,
	'img.gclms-notebook:click': GCLMS.PageController.loadNotebook,
	'#gradeQuestions:click': GCLMS.PageController.gradeQuestions,
	'.gclms-multiple-choice': {
		'input[type="radio"]:change': GCLMS.PageController.checkMultipleChoiceQuestion1,
		'.gclms-button.button.gclms-check-answer-button:click': GCLMS.PageController.checkMultipleChoiceQuestion
	},
	'.gclms-matching' : {
		'.gclms-button.gclms-check-answer-button:click': GCLMS.PageController.checkMatchingQuestion,
		'div.gclms-draggable': GCLMS.PageController.createMatchingDraggables,
		'div.gclms-droppable': GCLMS.PageController.createMatchingDroppables
	},
	'.gclms-fill-in-the-blank':{
		'input:keyup': GCLMS.PageController.expandFillInTheBlankField,
		'.gclms-button.gclms-check-answer-button:click': GCLMS.PageController.checkFillInTheBlankQuestion
	},
	'.gclms-order-question': {
		'ul': GCLMS.PageController.createOrderSortable,
		'.gclms-button.gclms-check-answer-button:click': GCLMS.PageController.checkOrderQuestion
	},	
	'.gclms-true-false .gclms-button.gclms-check-answer-button:click': GCLMS.PageController.checkTrueFalseQuestion,
	'div.gclms-framed' : {
		':loaded': GCLMS.PageController.highlightCurrentPage,
		'a[href*="/pages/view"]:click': GCLMS.PageController.gotoPageLink,
		'a[href*="/www.bibleapi.net"]:click': GCLMS.PageController.loadBibleVerse,
		'a[href*="/chapters/view"]:click': GCLMS.PageController.loadChapter,
		'a[href*="/articles/view"]:click': GCLMS.PageController.loadArticle,
		'a[href*="/glossary/view"]:click': GCLMS.PageController.loadGlossaryTerm
	}
});