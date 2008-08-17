/*global $, $A, $F, $$, Ajax, Element, GCLMS, Sortable, document, window, self, UUID, __, Draggable, Effect, location, Droppables, parent, top, swfobject */

GCLMS.PageController = {
    loadPage: function(){
        if (swfobject.getFlashPlayerVersion().major < 9) {
            $$('.gclms-upgrade-flash').first().removeClassName('gclms-hidden');
            return false;
        }
        
        /*mp3Player = $$('div.gclms-mp3-player')[0];
         
         if (window.soundManager !== undefined && mp3Player) {
         soundManager.useConsole = false;
         soundManager.debugMode = false;
         
         soundManager.createMovie('/js/vendors/sound_manager/soundmanager2.swf');
         
         mp3Player.insert(new Element('div', {
         className: 'gclms-play'
         }));
         mp3Player.insert(new Element('div', {
         className: 'gclms-blank-track'
         }));
         mp3Player.insert(new Element('div', {
         className: 'gclms-progress-track'
         }));
         mp3Player.insert(new Element('div', {
         className: 'gclms-transparent-track'
         }).insert(new Element('div', {
         className: 'handle'
         })));
         
         soundManager.onload = function(){
         $$('div.mp3player').each(function(node){
         var MP3PlayerObject = new MP3Player(node);
         });
         };
         }
         */
    },
    
    createOrderSortable: function(event){
        Sortable.create(this.getAttribute('id'), {
            containment: this,
            scroll: window
        });
    },
    
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
    gradeQuestions: function(event){
        event.stop();
        var totalQuestions = 0;
        var totalCorrectAnswers = 0;
        
        $$('.questions > div').each(function(question){
            totalQuestions++;
            if (question.hasClassName('gclms-multiple-choice')) {
                var div = question;
                var completelyCorrect = true;
                var atLeastPartiallyCorrect = false;
                
                $A(div.select('input')).each(function(node){
                    if (node.checked) {
                        if (node.getAttribute('gclms:answer-correct') == 'true') {
                            atLeastPartiallyCorrect = true;
                        }
                        else {
                            completelyCorrect = false;
                        }
                    }
                    else {
                        if (node.getAttribute('gclms:answer-correct') == 'true') {
                            completelyCorrect = false;
                        }
                    }
                });
                
                if (completelyCorrect) {
                    totalCorrectAnswers++;
                    var graphic = '<img src="/img/check-22.png" /> ';
                    question.style.backgroundColor = '#DBFFDB';
                }
                else {
                    graphic = '<img src="/img/red_x-22.png" /> ';
                    question.style.backgroundColor = '#FEE5E2';
                }
                question.select('h3').first().insert({
                    top: graphic
                });
                
            }
            else 
                if (question.hasClassName('matching')) {
                    completelyCorrect = true;
                    div = question;
                    
                    div.select('.gclms-droppable').each(function(node){
                        if (node.getAttribute('gclms:attempted-answer-id') != node.getAttribute('correctAnswer:id')) {
                            completelyCorrect = false;
                        }
                    });
                    
                    if (completelyCorrect) {
                        totalCorrectAnswers++;
                        graphic = '<img src="/img/check-22.png" /> ';
                        question.style.backgroundColor = '#DBFFDB';
                    }
                    else {
                        graphic = '<img src="/img/red_x-22.png" /> ';
                        question.style.backgroundColor = '#FEE5E2';
                    }
                    question.select('h3').first().insert({
                        top: graphic
                    });
                }
                else 
                    if (question.hasClassName('gclms-true-false')) {
                    
                    }
                    else 
                        if (question.hasClassName('gclms-fill-in-the-blank')) {
                            div = question;
                            var input = div.getElementsByTagName('input').item(0);
                            
                            if (input.value.strip().toLowerCase() == input.getAttribute('correctAnswer:text').trim().toLowerCase()) {
                                totalCorrectAnswers++;
                                graphic = '<img src="/img/check-22.png" /> ';
                                question.style.backgroundColor = '#DBFFDB';
                            }
                            else {
                                graphic = '<img src="/img/red_x-22.png" /> ';
                                question.style.backgroundColor = '#FEE5E2';
                            }
                            question.select('h3').first().insert({
                                top: graphic
                            });
                        }
            return false;
        });
        $('gradeResults').update('Submitting grade...');
        var request = new Ajax.Request('/' + document.body.getAttribute('gclms:group') + '/grades/update_assessment/section:' + document.body.getAttribute('section:id') + '/page:' + document.body.getAttribute('page:id') + '/grade:' + totalCorrectAnswers + '/maximum_possible:' + totalQuestions, {
            onSuccess: function(request){
                document.body.insert(request.responseText);
                $('gradeResults').update('Your score is ' + totalCorrectAnswers + ' out of ' + totalQuestions + '.');
            }
        });
    },
    createMatchingDraggables: function(event){
        var draggable = new Draggable(this, {
            revert: true,
            ghosting: false,
            reverteffect: function(element, top_offset, left_offset){
                var moveEffect = new Effect.Move(element, {
                    x: -left_offset,
                    y: -top_offset,
                    duration: 0
                });
            }
        });
    },
    createMatchingDroppables: function(event){
        Droppables.add(this, {
            containment: $A(this.up('div.gclms-matching').select('td.gclms-draggable-container')),
            onDrop: function(draggableElement, droppableElement){
            
                // See if answer has already been dropped
                var tbody = droppableElement.findParent('tbody');
                
                tbody.select('div.gclms-droppable').each(function(node){
                    if (node.getAttribute('gclms:attempted-answer-id') == this.getAttribute('gclms:answer-id')) {
                        node.removeAttribute('gclms:attempted-answer-id');
                        node.innerHTML = '';
                        node.className = 'gclms-droppable gclms-default-droppable-color';
                    }
                }
.bind(draggableElement));
                
                // Clone answer into droppable container
                droppableElement.className = 'gclms-droppable ' + $A(draggableElement.classNames())[1];
                droppableElement.innerHTML = draggableElement.innerHTML;
                droppableElement.setAttribute('gclms:attempted-answer-id', draggableElement.getAttribute('gclms:answer-id'));
                // */
            }
        });
    },
    
    checkEssayQuestion: function(event){
        event.stop();
        var div = this.up('div.gclms-essay-question').down('.gclms-explanation').displayAsBlock();
        this.up('div.gclms-buttons').remove();
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
            }
        answerStatus.displayAsBlock();
        var effect = new Effect.Highlight(answerStatusSpan, {
            endcolor: '#f6f6f6',
            restorecolor: '#f6f6f6'
        });
    },
    
    expandFillInTheBlankField: function(event){
        var answerLength = this.value.length;
        
        if (this.size < answerLength && answerLength < 100 && answerLength > 30) {
            this.size = answerLength;
        }
        else {
            if (this.size > answerLength && this.size > 30) {
                this.size = 30;
            }
        }
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
    loadBibleVerse: function(event){
        top.Ext.getCmp('bibleViewport').expand();
        //if (!top.$('bibleViewportContent').contentDocument.body.innerHTML) {
        top.$('bibleViewportContent').src = this.getAttribute('href');
        //}
        event.stop();
    },
    
    loadChapter: function(event){
        var url = this.getAttribute('href').split('chapters/view/');
        
        top.Ext.getCmp('booksViewport').expand();
        top.$('booksViewportContent').src = GCLMS.urlPrefix + 'chapters/view/' + url[1] + '?framed';
        event.stop();
    },
    
    loadArticle: function(event){
        var url = this.getAttribute('href').split('articles/view/');
        
        top.Ext.getCmp('articlesViewport').expand();
        top.$('articlesViewportContent').src = GCLMS.urlPrefix + 'articles/view/' + url[1] + '?framed';
        event.stop();
    },
    
    loadGlossaryTerm: function(event){
        var url = this.getAttribute('href').split('glossary/view/');
        
        top.Ext.getCmp('glossaryViewport').expand();
        //if (!top.$('glossaryViewportContent').contentDocument.body.innerHTML) {
        top.$('glossaryViewportContent').src = GCLMS.urlPrefix + 'glossary/view/' + url[1] + '?framed';
        event.stop();
    },
    
    loadNotebook: function(){
        parent.Ext.getCmp('classroomTabs').activate('notebookTab');
    },
    
    gotoPageLink: function(event){
        location.href = this.getAttribute('href') + '?framed';
        event.stop();
    },
    
    highlightCurrentPage: function(){
        try {
            top.GCLMS.ClassroomController.highlightCurrentPage(location.href);
        } 
        catch (e) {
        }
    },
    
    loadFlashPlayer: function(){
        var src = this.getAttribute('value');
		var parentNode = this.parentNode;
		var w = parentNode.getAttribute('width');
        var h = parentNode.getAttribute('height');
        var flashvars = {
            bgcolor: '#444'
        };
        var params = {
            bgcolor: '#444'
        };
        var attributes = {};
		
        flashvars = {
            bgcolor: '#444',
            config: "{controlBarBackgroundColor: -1,timeDisplayFontColor: -1,loop: false,controlsOverVideo: 'ease', controlBarGloss: 'low',showMenu: false,showFullScreenButton: false,useNativeFullScreen: false,autoBuffering: false,autoPlay: false,videoFile: '" + src + "'}"
        };
		//	
		swfobject.embedSWF('/js/vendors/flowplayer2.2.2/FlowPlayerLight.swf', $(parentNode).identify(), w, h, '9.0.0', '/js/vendors/swfobject2.1/expressInstall.swf', flashvars, params, attributes);
    }
};

GCLMS.Triggers.update({
    'div.gclms-page': GCLMS.PageController.loadPage,
    'img.gclms-notebook:click': GCLMS.PageController.loadNotebook,
    '#gradeQuestions:click': GCLMS.PageController.gradeQuestions,
    '.gclms-multiple-choice': {
        'input[type="radio"]:change': GCLMS.PageController.checkMultipleChoiceSingleSelectionQuestion,
        '.gclms-button.gclms-check-answer-button:click': GCLMS.PageController.checkMultipleChoiceMultipleSelectionQuestion
    },
    '.gclms-matching': {
        '.gclms-button.gclms-check-answer-button:click': GCLMS.PageController.checkMatchingQuestion,
        'div.gclms-draggable': GCLMS.PageController.createMatchingDraggables,
        'div.gclms-droppable': GCLMS.PageController.createMatchingDroppables
    },
    '.gclms-fill-in-the-blank': {
        'input:keyup': GCLMS.PageController.expandFillInTheBlankField,
        '.gclms-button.gclms-check-answer-button:click': GCLMS.PageController.checkFillInTheBlankQuestion
    },
    '.gclms-order-question': {
        'ul': GCLMS.PageController.createOrderSortable,
        '.gclms-button.gclms-check-answer-button:click': GCLMS.PageController.checkOrderQuestion
    },
    '.gclms-essay-question .gclms-button.gclms-check-answer-button:click': GCLMS.PageController.checkEssayQuestion,
    '.gclms-true-false .gclms-button.gclms-check-answer-button:click': GCLMS.PageController.checkTrueFalseQuestion,
    'div.gclms-framed': {
        ':loaded': GCLMS.PageController.highlightCurrentPage,
        'a[href*="/pages/view"]:click': GCLMS.PageController.gotoPageLink,
        'a[href*="/www.bibleapi.net"]:click': GCLMS.PageController.loadBibleVerse,
        'a[href*="/chapters/view"]:click': GCLMS.PageController.loadChapter,
        'a[href*="/articles/view"]:click': GCLMS.PageController.loadArticle,
        'a[href*="/glossary/view"]:click': GCLMS.PageController.loadGlossaryTerm
    },
    //'embed[src*=.flv]:loaded,embed[src*=.mp4]:loaded': GCLMS.PageController.loadFlashPlayer
	//'object[codebase*=swflash.cab]': GCLMS.PageController.loadFlashPlayer,
	'param[value*="flv"],param[value*="mp4"]': GCLMS.PageController.loadFlashPlayer
});