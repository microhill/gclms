/* global $, $$, Ajax, Element, GCLMS, Sortable, document, window, self, UUID, __ */

GCLMS.PageController = {
	createOrderSortable: function(event) {
		Sortable.create(this.getAttribute('id'),{
			containment: this,
			scroll: window
		});
	},
	checkMultipleChoiceQuestion: function(event) {
		div = event.findElement('div');
		completelyCorrect = true;
		atLeastPartiallyCorrect = false;

		$A(div.select('input')).each(function(node) {
			if(node.checked) {
				if(node.getAttribute('answer:correct') == 'true') {
					atLeastPartiallyCorrect = true;
				} else {
					completelyCorrect = false;
				}
			} else {
				if(node.getAttribute('answer:correct') == 'true') {
					completelyCorrect = false;
				}
			}
		});

		if(completelyCorrect) {
			alert(div.getAttribute('question:defaultCorrectMessage'));
		} else if(parseInt(div.getAttribute('question:triesLeft'),10) > 0) {
			div.setAttribute('question:triesLeft',parseInt(div.getAttribute('question:triesLieft'),10) - 1);
			if(atLeastPartiallyCorrect) {
				alert(div.getAttribute('question:defaultPartiallyCorrectMessage'));
			} else {
				alert(div.getAttribute('question:defaultTryAgainMessage'));
			}
		} else {
			//Set to correct answers
			div.select('input').each(function(node) {
				if(node.getAttribute('answer:correct') == 'true') {
					node.checked = true;
				} else if(node.getAttribute('answer:correct') == 'false') {
					node.checked = false;
					node.removeAttribute('checked');
				}
			});
			alert(div.getAttribute('question:defaultNoMoreIncorrectTriesMessage'));
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
			alert(div.getAttribute('question:defaultCorrectMessage'));
		} else if(parseInt(div.getAttribute('question:triesLeft'),10) > 0) {
			div.setAttribute('question:triesLeft',parseInt(div.getAttribute('question:triesLieft'),10) - 1);
			if(atLeastPartiallyCorrect) {
				alert(div.getAttribute('question:defaultPartiallyCorrectMessage'));
			} else {
				alert(div.getAttribute('question:defaultTryAgainMessage'));
			}
		} else {
			//Set to correct answers

			div.select('gclms-droppable').each(function(node){
				id = node.getAttribute('correctAnswer:id');

				draggableElement = div.select('div.gclms-draggable[answer:id="' + id + '"]').first();

				node.className = 'gclms-droppable ' + $A(draggableElement.classNames())[1];
				node.innerHTML = draggableElement.innerHTML;
				node.setAttribute('attemptedAnswer:id',draggableElement.getAttribute('answer:id'));
			});

			alert(div.getAttribute('question:defaultNoMoreIncorrectTriesMessage'));
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
						if(node.getAttribute('answer:correct') == 'true') {
							atLeastPartiallyCorrect = true;
						} else {
							completelyCorrect = false;
						}
					} else {
						if(node.getAttribute('answer:correct') == 'true') {
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
					if(node.getAttribute('attemptedAnswer:id') == this.getAttribute('answer:id')) {
						node.removeAttribute('attemptedAnswer:id');
						node.innerHTML = '';
						node.className = 'gclms-droppable gclms-default-droppable-color';
					}
				}.bind(draggableElement));

				// Clone answer into droppable container
				droppableElement.className = 'gclms-droppable ' + $A(draggableElement.classNames())[1];
				droppableElement.innerHTML = draggableElement.innerHTML;
				droppableElement.setAttribute('attemptedAnswer:id',draggableElement.getAttribute('answer:id'));
				// */
			}
		});
	},
	checkFillInTheBlankQuestion: function(event) {
		div = event.findElement('div');
		input = div.getElementsByTagName('input').item(0);

		if(input.value.trim().toLowerCase() == input.getAttribute('correctAnswer:text').trim().toLowerCase()) {
			alert(div.getAttribute('question:defaultCorrectMessage'));
		} else if(parseInt(div.getAttribute('question:triesLeft'),10) > 0) {
			div.setAttribute('question:triesLeft',parseInt(div.getAttribute('question:triesLieft'),10) - 1);
			alert(div.getAttribute('question:defaultTryAgainMessage'));
		} else {
			correctAnswer = input.getAttribute('correctAnswer:text').trim();
			$A(div.getElementsByTagName('p')).each(function(node){
				Element.remove(node);
			});
			var tmpInsertion1 = new Insertion.Bottom(div,'<p class="gclms-correct-answer">' + correctAnswer + '</p>');
			alert(div.getAttribute('question:defaultNoMoreIncorrectTriesMessage'));
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

	checkTrueFalseQuestion: function(event) {
		div = event.findElement('div');
		correctAnswerInteger = div.getAttribute('correctAnswer:integer');

		if(this.getAttribute('answer:integer') == correctAnswerInteger) {
			$A(div.getElementsByTagName('p')).each(function(node){
				Element.remove(node);
			});
			if (correctAnswerInteger == "0") {
				var tmpInsertion1 = new Insertion.Bottom(div, '<p class="gclms-correct-answer">' + div.getAttribute('question:defaultCorrectMessageFalse') + ' ' + div.getAttribute('correctAnswer:explanation') + '</p>');
			}
			else {
				var tmpInsertion2 = new Insertion.Bottom(div, '<p class="gclms-correct-answer">' + div.getAttribute('question:defaultCorrectMessageTrue') + ' ' + div.getAttribute('correctAnswer:explanation') + '</p>');
			}
		} else {
			$A(div.getElementsByTagName('p')).each(function(node){
				Element.remove(node);
			});
			if (correctAnswerInteger == "0") {
				var tmpInsertion3 = new Insertion.Bottom(div, '<p class="gclms-correct-answer">' + div.getAttribute('question:defaultIncorrectMessageFalse') + ' ' + div.getAttribute('correctAnswer:explanation') + '</p>');
			}
			else {
				var tmpInsertion4 = new Insertion.Bottom(div, '<p class="gclms-correct-answer">' + div.getAttribute('question:defaultIncorrectMessageTrue') + ' ' + div.getAttribute('correctAnswer:explanation') + '</p>');
			}
		}
		event.stop();
	},
	loadBibleVerse: function(event) {
		top.Ext.getCmp('bibleViewport').expand();
		if (!top.$('bibleViewportContent').contentDocument.body.innerHTML) {
			top.$('bibleViewportContent').src = this.getAttribute('href');
		}
		event.stop();
	},

	loadChapter: function(event) {
		top.Ext.getCmp('textbooksViewport').expand();
		if (!top.$('textbooksViewportContent').contentDocument.body.innerHTML) {
			top.$('textbooksViewportContent').src = this.getAttribute('href');
		}
		event.stop();
	},
	
	loadArticle: function(event) {
		var url = this.getAttribute('href').split('articles/view/');

		top.Ext.getCmp('articlesViewport').expand();
		//if (!top.$('articlesViewportContent').contentDocument.body.innerHTML) {
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
		return false;
	},
	
	highlightCurrentPage: function() {
		try {
			top.GCLMS.ClassroomController.highlightCurrentPage(location.href);
		} catch(e){};
	},
	
	test: function() {
		alert('test2');
	}
}

GCLMS.Triggers.update({
	//'div.gclms-page': GCLMS.PageController.loadPageAudio,
	'img.gclms-notebook:click': GCLMS.PageController.loadNotebook,
	'#gradeQuestions:click': GCLMS.PageController.gradeQuestions,
	'.gclms-multiple-choice button.gclms-check-answer-button:click': GCLMS.PageController.checkMultipleChoiceQuestion,
	'.gclms-matching' : {
		'button.gclms-check-answer-button:click': GCLMS.PageController.checkMatchingQuestion,
		'div.gclms-draggable': GCLMS.PageController.createMatchingDraggables,
		'div.gclms-droppable': GCLMS.PageController.createMatchingDroppables
	},
	'.gclms-fill-in-the-blank':{
		'input:keyup': GCLMS.PageController.expandFillInTheBlankField,
		'button.gclms-check-answer-button:click': GCLMS.PageController.checkFillInTheBlankQuestion
	},
	'.gclms-order-question': {
		'ul': GCLMS.PageController.createOrderSortable
	},	
	'.gclms-true-false button:click': GCLMS.PageController.checkTrueFalseQuestion,
	'div.gclms-framed' : {
		'a:not([href*=/]):click': GCLMS.PageController.gotoPageLink,
		':loaded': GCLMS.PageController.highlightCurrentPage,
		'a[href*="/bible_kjv/"]:click': GCLMS.PageController.loadBibleVerse,
		'a[href*="/chapters/"]:click': GCLMS.PageController.loadChapter,
		'a[href*="/articles/"]:click': GCLMS.PageController.loadArticle,
		'a[href*="/glossary/"]:click': GCLMS.PageController.loadGlossaryTerm
	}
});