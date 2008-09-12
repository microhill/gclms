/*global $, $A, $F, $$, Ajax, Element, gclms, Sortable, document, window, self, UUID, __, Draggable, Effect, location, Droppables, parent, top, swfobject */

gclms.PageController = {
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
                }.bind(draggableElement));
                
                // Clone answer into droppable container
                droppableElement.className = 'gclms-droppable ' + $A(draggableElement.classNames())[1];
                droppableElement.innerHTML = draggableElement.innerHTML;
                droppableElement.setAttribute('gclms:attempted-answer-id', draggableElement.getAttribute('gclms:answer-id'));
                // */
            }
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
        top.$('booksViewportContent').src = gclms.urlPrefix + 'chapters/view/' + url[1];
        event.stop();
    },
    
    loadArticle: function(event){
        var url = this.getAttribute('href').split('articles/view/');
        
        top.Ext.getCmp('articlesViewport').expand();
        top.$('articlesViewportContent').src = gclms.urlPrefix + 'articles/view/' + url[1];
        event.stop();
    },
    
    loadGlossaryTerm: function(event){
        var url = this.getAttribute('href').split('glossary/view/');
        
        top.Ext.getCmp('glossaryViewport').expand();
        //if (!top.$('glossaryViewportContent').contentDocument.body.innerHTML) {
        top.$('glossaryViewportContent').src = gclms.urlPrefix + 'glossary/view/' + url[1];
        event.stop();
    },
    
    loadNotebook: function(){
        parent.Ext.getCmp('classroomTabs').activate('notebookTab');
    },
    
    gotoPageLink: function(event){
        if (!this.parentNode.hasClassName('gclms-option-buttons')) {
			location.href = this.getAttribute('href') + '?framed';
			event.stop();
		}
    },
    
    highlightCurrentPage: function(){
        try {
            top.gclms.ClassroomController.highlightCurrentPage(location.href);
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
    },
	
	enableTinyMCE: function() {
		tinyMCE.settings = gclms.notebookAndEssayTinyMCEConfig;
		tinyMCE.execCommand('mceAddControl', false, this.identify());
	}
};

gclms.Triggers.update({
    'div.gclms-essay-question textarea': gclms.PageController.enableTinyMCE,
	'div.gclms-page': gclms.PageController.loadPage,
    'img[src="/img/notebook-32.png"]:click': gclms.PageController.loadNotebook,
    //'#gradeQuestions:click': gclms.PageController.gradeQuestions,
    'div.gclms-framed': {
        ':loaded': gclms.PageController.highlightCurrentPage,
        'a[href*="/pages/view"]:click': gclms.PageController.gotoPageLink,
        'a[href*="/www.bibleapi.net"]:click': gclms.PageController.loadBibleVerse,
        'a[href*="/chapters/view"]:click': gclms.PageController.loadChapter,
        'a[href*="/articles/view"]:click': gclms.PageController.loadArticle,
        'a[href*="/glossary/view"]:click': gclms.PageController.loadGlossaryTerm
    },
    //'embed[src*=.flv]:loaded,embed[src*=.mp4]:loaded': gclms.PageController.loadFlashPlayer
	//'object[codebase*=swflash.cab]': gclms.PageController.loadFlashPlayer,
	'param[value*="flv"],param[value*="mp4"]': gclms.PageController.loadFlashPlayer
});

/*
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
        var request = new Ajax.Request('/' + document.body.getAttribute('gclms-group') + '/grades/update_assessment/section:' + document.body.getAttribute('section:id') + '/page:' + document.body.getAttribute('page:id') + '/grade:' + totalCorrectAnswers + '/maximum_possible:' + totalQuestions, {
            onSuccess: function(request){
                document.body.insert(request.responseText);
                $('gradeResults').update('Your score is ' + totalCorrectAnswers + ' out of ' + totalQuestions + '.');
            }
        });
    },
*/

gclms.notebookAndEssayTinyMCEConfig = {
	theme : 'advanced',
	content_css: '/css/tinymce.css',
	//theme_advanced_buttons1 : '',
	convert_urls: false,
	tab_focus : ':next',
	gecko_spellcheck: true,
	mode: 'none',
	theme_advanced_toolbar_location : 'top',
	theme_advanced_toolbar_align : 'left',
	theme_advanced_buttons1 : 'bold,italic,underline,blockquote,bullist,numlist,removeformat',
	theme_advanced_buttons2 : '',
    language: document.body.getAttribute('gclms-language'),
	//cleanup_serializer: 'xml',
	button_tile_map: true,
	extended_valid_elements : 'a[name|href|target|title],em,i,ol,ul,li,u,strong,b,u',
	plugins: 'paste',
	paste_auto_cleanup_on_paste: true
};