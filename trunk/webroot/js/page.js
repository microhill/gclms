GCLMS.Triggers.update({
	'img.gclms-notebook:click' : function(event) {
		parent.Ext.getCmp('classroomTabs').activate('notebookTab');
	},
	'#gradeQuestions:click' : function(event){
		event.stop();
		totalQuestions = 0;
		totalCorrectAnswers = 0;

		$$('.questions > div').each(function(question){
			totalQuestions++;
			if(question.hasClassName('multipleChoice')) {
				div = question;
				completelyCorrect = true;
				atLeastPartiallyCorrect = false;

				$A(div.getElementsByTagName('input')).each(function(node) {
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
				})

				if(completelyCorrect) {
					totalCorrectAnswers++;
					graphic = '<img src="/img/check-22.png" /> ';
					question.style.backgroundColor = '#DBFFDB';
				} else {
					graphic = '<img src="/img/red_x-22.png" /> ';
					question.style.backgroundColor = '#FEE5E2';
				}
				question.getElementsBySelector('h3').first().insert({top: graphic});

			} else if(question.hasClassName('matching')) {
				completelyCorrect = true;
				div = question;

				div.getElementsByClassName('droppable').each(function(node){
					if(node.getAttribute('attemptedAnswer:id') != node.getAttribute('correctAnswer:id'))
						completelyCorrect = false;
				});

				if(completelyCorrect) {
					totalCorrectAnswers++;
					graphic = '<img src="/img/check-22.png" /> ';
					question.style.backgroundColor = '#DBFFDB';
				} else {
					graphic = '<img src="/img/red_x-22.png" /> ';
					question.style.backgroundColor = '#FEE5E2';
				}
				question.getElementsBySelector('h3').first().insert({top: graphic});
			} else if(question.hasClassName('trueFalse')) {

			} else if(question.hasClassName('fillInTheBlank')) {
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
				question.getElementsBySelector('h3').first().insert({top: graphic});
			}
			return false;
		});
		$('gradeResults').update('Submitting grade...');
		new Ajax.Request('/' + document.body.getAttribute('lms:group') + '/grades/update_assessment/section:' + document.body.getAttribute('section:id') + '/page:' + document.body.getAttribute('page:id') + '/grade:' + totalCorrectAnswers + '/maximum_possible:' + totalQuestions, {
		  onSuccess: function(request) {
			document.body.insert(request.responseText);
			$('gradeResults').update('Your score is ' + totalCorrectAnswers + ' out of ' + totalQuestions + '.');
		  }
		});
	},
	'.multipleChoice button.checkAnswerButton:click' : function(event) {
		div = event.findElement('div');
		completelyCorrect = true;
		atLeastPartiallyCorrect = false;

		$A(div.getElementsByTagName('input')).each(function(node) {
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
		})

		if(completelyCorrect) {
			alert(div.getAttribute('question:defaultCorrectMessage'));
		} else if(parseInt(div.getAttribute('question:triesLeft')) > 0) {
			div.setAttribute('question:triesLeft',parseInt(div.getAttribute('question:triesLieft')) - 1);
			if(atLeastPartiallyCorrect) {
				alert(div.getAttribute('question:defaultPartiallyCorrectMessage'));
			} else {
				alert(div.getAttribute('question:defaultTryAgainMessage'));
			}
		} else {
			//Set to correct answers
			div.getElementsBySelector('input').each(function(node) {
				if(node.getAttribute('answer:correct') == 'true') {
					node.checked = true;
				} else if(node.getAttribute('answer:correct') == 'false') {
					node.checked = false;
					node.removeAttribute('checked');
				}
			})
			alert(div.getAttribute('question:defaultNoMoreIncorrectTriesMessage'));
		}

		event.stop();
	},
	'.matching' : {
		'button.checkAnswerButton:click' : function(event) {
			div = $(event.findElement('div'));
			completelyCorrect = true;
			atLeastPartiallyCorrect = false;

			div.getElementsByClassName('droppable').each(function(node){
				if(node.getAttribute('attemptedAnswer:id') != node.getAttribute('correctAnswer:id'))
					completelyCorrect = false;
				else
					atLeastPartiallyCorrect = true;
			});

			if(completelyCorrect) {
				alert(div.getAttribute('question:defaultCorrectMessage'));
			} else if(parseInt(div.getAttribute('question:triesLeft')) > 0) {
				div.setAttribute('question:triesLeft',parseInt(div.getAttribute('question:triesLieft')) - 1);
				if(atLeastPartiallyCorrect) {
					alert(div.getAttribute('question:defaultPartiallyCorrectMessage'));
				} else {
					alert(div.getAttribute('question:defaultTryAgainMessage'));
				}
			} else {
				//Set to correct answers

				div.getElementsByClassName('droppable').each(function(node){
					id = node.getAttribute('correctAnswer:id');

					draggableElement = div.getElementsBySelector('div.draggable[answer:id="' + id + '"]').first();

					node.className = 'droppable ' + $A(draggableElement.classNames())[1];
					node.innerHTML = draggableElement.innerHTML;
					node.setAttribute('attemptedAnswer:id',draggableElement.getAttribute('answer:id'));
				});

				alert(div.getAttribute('question:defaultNoMoreIncorrectTriesMessage'));
			}

			event.stop();
		},
		'div.draggable' : function(event) {
			new Draggable(this,{
				revert:true,
				ghosting:true,
				reverteffect: function(element, top_offset, left_offset){
			        new Effect.Move(element, { x: -left_offset, y: -top_offset, duration: 0});
				}
			});
		},
		'div.droppable' : function(event) {
			Droppables.add(this, {
				containment: $A(this.up('div.matching').select('td.draggableContainer')),
				onDrop: function(draggableElement, droppableElement) {
					// See if answer has already been dropped
					tbody = droppableElement.findParent('tbody');
					
					tbody.select('div.droppable').each(function(node){
						if(node.getAttribute('attemptedAnswer:id') == this.getAttribute('answer:id')) {
							node.removeAttribute('attemptedAnswer:id');
							node.innerHTML = '';
							node.className = 'droppable defaultDroppableColor';
						}
					}.bind(draggableElement));

					// Clone answer into droppable container
					droppableElement.className = 'droppable ' + $A(draggableElement.classNames())[1];
					droppableElement.innerHTML = draggableElement.innerHTML;
					droppableElement.setAttribute('attemptedAnswer:id',draggableElement.getAttribute('answer:id'));
				}
			});
		}
	},
	'.fillInTheBlank' :{
		'input:keyup' : function(event) {
			answerLength = this.value.length;

			if(this.size < answerLength && answerLength < 100 && answerLength > 30)
				this.size = answerLength;
			else if(this.size > answerLength && this.size > 30)
				this.size = 30;
		},
		'button.checkAnswerButton:click' : function(event) {
			div = event.findElement('div');
			input = div.getElementsByTagName('input').item(0);

			if(input.value.trim().toLowerCase() == input.getAttribute('correctAnswer:text').trim().toLowerCase()) {
				alert(div.getAttribute('question:defaultCorrectMessage'));
			} else if(parseInt(div.getAttribute('question:triesLeft')) > 0) {
				div.setAttribute('question:triesLeft',parseInt(div.getAttribute('question:triesLieft')) - 1);
				alert(div.getAttribute('question:defaultTryAgainMessage'));
			} else {
				correctAnswer = input.getAttribute('correctAnswer:text').trim();
				$A(div.getElementsByTagName('p')).each(function(node){Element.remove(node)});
				new Insertion.Bottom(div,'<p class="correctAnswer">' + correctAnswer + '</p>');
				alert(div.getAttribute('question:defaultNoMoreIncorrectTriesMessage'));
			}
		}
	},
	'.trueFalse button:click' : function(event) {
		div = event.findElement('div');
		correctAnswerInteger = div.getAttribute('correctAnswer:integer');

		if(this.getAttribute('answer:integer') == correctAnswerInteger) {
			$A(div.getElementsByTagName('p')).each(function(node){Element.remove(node)});
			if(correctAnswerInteger == "0")
				new Insertion.Bottom(div,'<p class="correctAnswer">' + div.getAttribute('question:defaultCorrectMessageFalse') + ' ' + div.getAttribute('correctAnswer:explanation') + '</p>');
			else
				new Insertion.Bottom(div,'<p class="correctAnswer">' + div.getAttribute('question:defaultCorrectMessageTrue') + ' ' + div.getAttribute('correctAnswer:explanation') + '</p>');

		} else {
			$A(div.getElementsByTagName('p')).each(function(node){Element.remove(node)});
			if(correctAnswerInteger == "0")
				new Insertion.Bottom(div,'<p class="correctAnswer">' + div.getAttribute('question:defaultIncorrectMessageFalse') + ' ' + div.getAttribute('correctAnswer:explanation') + '</p>');
			else
				new Insertion.Bottom(div,'<p class="correctAnswer">' + div.getAttribute('question:defaultIncorrectMessageTrue') + ' ' + div.getAttribute('correctAnswer:explanation') + '</p>');
		}
		event.stop();
	},
	'a[href*="/bible_kjv/"]:click': function(event) {
		top.Ext.getCmp('bibleViewport').expand();
		if(!top.$('bibleViewportContent').contentDocument.body.innerHTML)
			top.$('bibleViewportContent').src = this.getAttribute('href');
		event.stop();
	},
	'a[href*="/chapters/"]:click': function(event) {
		top.Ext.getCmp('textbooksViewport').expand();
		if(!top.$('textbooksViewportContent').contentDocument.body.innerHTML)
			top.$('textbooksViewportContent').src = this.getAttribute('href');
		event.stop();
	},
	'a[href*="/articles/"]:click': function(event) {
		top.Ext.getCmp('articlesViewport').expand();
		if(!top.$('articlesViewportContent').contentDocument.body.innerHTML)
			top.$('articlesViewportContent').src = this.getAttribute('href');
		event.stop();
	},
	'a[href*="/dictionary/"]:click': function(event) {
		top.Ext.getCmp('dictionaryViewport').expand();
		if(!top.$('dictionaryViewportContent').contentDocument.body.innerHTML)
			top.$('dictionaryViewportContent').src = this.getAttribute('href');
		event.stop();
	}
});

mp3Player = $$('div.mp3player')[0];

if(window.soundManager !== undefined && mp3Player) {
	soundManager.useConsole = false;
	soundManager.debugMode = false;

	soundManager.createMovie('/js/vendors/sound_manager/soundmanager2.swf');

	mp3Player.insert(new Element('div', {className: 'play'}));
	mp3Player.insert(new Element('div', {className: 'blankTrack'}));
	mp3Player.insert(new Element('div', {className: 'progressTrack'}));
	mp3Player.insert(new Element('div', {className: 'transparentTrack'}).insert(
			new Element('div', {className: 'handle'})
	));

	soundManager.onload = function(){
		$$('div.mp3player').each(function(node){
			new MP3Player(node);
		});
	}
}
	