/*global $, $$, Ajax, Element, GCLMS, Sortable, document, window, self, UUID, Event, __ */

GCLMS.ContentController = {
	initialize: function() {
		$$('#gclms-nodes li.gclms-hidden > ul > li').each(function(li) {
			li.hide();
			li.removeClassName('gclms-hidden');
		});
		$$('#gclms-nodes li.gclms-hidden').each(function(li) {
			li.removeClassName('gclms-hidden');
		});		
		GCLMS.ContentController.createSortables();
		GCLMS.ContentController.toggleMenubarButtons();
	},
	toggleNodeExpansion: function() {
		var li = this.up('li');
		
		if(li.hasClassName('gclms-collapsed')) {
			$$('#' + li.getAttribute('id') + ' > ul > li').each(function(node){
				node.displayAsBlock();
			});
			li.removeClassName('gclms-collapsed');
			li.addClassName('gclms-expanded');
		} else if(li.hasClassName('gclms-expanded')) {
			$$('#' + li.getAttribute('id') + ' > ul > li').each(function(node){
				node.hide();
			});			
			li.addClassName('gclms-collapsed');
			li.removeClassName('gclms-expanded');
			if(li.down('a.selected')) {
				GCLMS.ContentController.selectNode.bind(li.down('a'))();
			}
		}
	},
	convertLabelToPage: function() {
		if (this.down('button').getAttribute('disabled')) {
			return false;
		}
			
		GCLMS.ContentController.convertNodeType(GCLMS.Node.PAGE_TYPE_INT);
	},
	convertPageToLabel: function() {
		if (this.down('button').getAttribute('disabled')) {
			return false;
		}

		GCLMS.ContentController.convertNodeType(GCLMS.Node.LABEL_TYPE_INT);
	},
	convertNodeType: function(type) {
		var li = $$('#gclms-nodes a.selected').first().up('li');
		
		li.toggleClassName('gclms-page');
		li.toggleClassName('gclms-label');
		
		GCLMS.ContentController.toggleMenubarButtons();
		
		GCLMS.Node.convertType({
			id: li.getAttribute('gclms:node-id'),
			type: type
		});	
	},
	editPage: function() {
		if(this.down('button').getAttribute('disabled')) {
			return false;
		}			

		var li = $$('#gclms-nodes a.selected').first().up('li');
		if(li.hasClassName('gclms-page')) {
			self.location = '/' + document.body.getAttribute('gclms:group') + '/' + document.body.getAttribute('gclms:course') + '/pages/edit/' + li.getAttribute('gclms:node-id');
		}
	},
	confirmDeleteNode: function() {		
		if(this.down('button').getAttribute('disabled')) {
			return false;	
		}			
		
		GCLMS.popup.create({
			text: this.down('button').getAttribute('gclms:confirm-text'),
			confirmButtonText: __('Yes'),
			cancelButtonText: __('No'),
			type: 'confirm',
			callback: GCLMS.ContentController.deleteNode
		});
		return false;
	},
	deleteNode: function() {
		var li = $$('#gclms-nodes a.selected').first().up('li');

		GCLMS.Node.remove({id: li.getAttribute('gclms:node-id')});
		var ul = li.up('ul');
	
		if(previousNode = li.previous('li')) {
			previousNode.down('a').addClassName('selected');
		} else if(parentNode = li.up('li')) {
			parentNode.down('a').addClassName('selected');
		} 

		li.remove();
		
		GCLMS.ContentController.toggleMenubarButtons();
		GCLMS.ContentController.toggleListClass(ul);
	},
	getNodeTitleForRename: function() {
		if(this.down('button').getAttribute('disabled')) {
			return false;
		}			

		GCLMS.popup.create({
			text: this.down('button').getAttribute('gclms:prompt-text'),
			value: $('gclms-nodes').down('a.selected').innerHTML,
			callback: GCLMS.ContentController.renameNode
		});
		return false;
	},
	renameNode: function(title) {
		var a = $$('#gclms-nodes a.selected').first();

		if (!title || a.innerHTML == title) {
			return false;
		}
			
		a.innerHTML = title;
		
		GCLMS.Node.rename({
			id: a.up('li').getAttribute('gclms:node-id'),
			title: title
		});	
	},
	getLabelTitleForAddition: function() {
		GCLMS.popup.create({
			text: this.down('button').getAttribute('gclms:prompt-text'),
			callback: GCLMS.ContentController.addLabel
		});
		return false;
	},
	getPageTitleForAddition: function() {
		GCLMS.popup.create({
			text: this.down('button').getAttribute('gclms:prompt-text'),
			callback: GCLMS.ContentController.addPage
		});
		return false;
	},	
	addLabel: function(title) {
		if(!title) {
			return false;
		}
		GCLMS.ContentController.addNode(title,'label');
	},
	addPage: function(title) {
		if(!title) {
			return false;
		}
		GCLMS.ContentController.addNode(title,'page');
	},
	addNode: function(title,type) {
		var id = UUID.generate();
	
		var ul = GCLMS.ContentController.selectListForNodeAddition();
		var parentNode = ul.up('li.gclms-node');
		var parentNodeId = parentNode ? parentNode.getAttribute('gclms:node-id') : 0;
			
		ul.insert(GCLMS.Views.get('node').interpolate({
			id: id,
			title: title,
			typeClass: 'gclms-' + type
		}));
	
		GCLMS.Node.add({
			parentNodeId: parentNodeId,
			id: id,
			title: title,
			type: type == 'label' ? 1 : 0,
			callback: function(request) {
				$('node_' + id).observeRules(GCLMS.Triggers.get('#gclms-nodes').li);
				GCLMS.ContentController.createSortables();
		}});
		
		GCLMS.ContentController.toggleListClass(ul);
	},
	selectListForNodeAddition: function() {
		var selectedNode = $('gclms-nodes').down('li a.selected');
		if(selectedNode) {
			var ul = selectedNode.up('li').down('ul');
			if(!ul) {
				selectedNode.up('li').insert(new Element('ul'));				
				ul = selectedNode.up('li').down('ul');
			}
			return ul;
		} else {
			return $('gclms-nodes').down('li.gclms-course').down('ul');
		}
	},
	selectNode: function(event) {		
		if(event) {
			event.stop();
		}
			
		$$('#gclms-nodes a').each(function(a){
			a.removeClassName('selected');
		});
		var li = this.findParent('li');
		var a = li.down('a');
		a.addClassName('selected');
		
		GCLMS.ContentController.toggleMenubarButtons();
		
		return false;
	},
	increaseIndent: function(event) {
		if(this.down('button').getAttribute('disabled')) {
			return false;			
		}


		var selectedNode = $('gclms-nodes').down('li a.selected').up('li');
		var selectedNodeList = selectedNode.up('ul');	
		var previousNode = selectedNode.previous('li');

		if(!previousNode || GCLMS.ContentController.countAncestorLevels(selectedNode) + GCLMS.ContentController.countDescendentLevels(selectedNode) > 2) {
			return false;
		}

		GCLMS.Node.increaseIndent({
			parentNodeId: previousNode.getAttribute('gclms:node-id'),
			id: selectedNode.getAttribute('gclms:node-id'),
			callback: function(request) {
				document.body.insert(request.responseText);
			}
		});

		var previousNodeChildList = previousNode.down('ul');
		
		previousNodeChildList.insert(selectedNode);

		GCLMS.ContentController.toggleListClass(selectedNodeList);
		GCLMS.ContentController.toggleListClass(previousNodeChildList);		

		GCLMS.ContentController.toggleMenubarButtons();
		GCLMS.ContentController.createSortables();

		return false;
	},
	decreaseIndent: function(event) {
		if (this.down('button').getAttribute('disabled')) {
			return false;
		}

		var selectedNode = $('gclms-nodes').down('li a.selected').up('li');
		var selectedNodeList = selectedNode.up('ul');
		var parentNode = selectedNode.up('li');
		var parentNodeList = parentNode.up('ul');

		if(!parentNode || GCLMS.ContentController.countAncestorLevels(selectedNode) < 1) {
			return false;
		}
		
		GCLMS.Node.decreaseIndent({
			parentNodeId: parentNodeList.up('li').getAttribute('gclms:node-id'),
			id: selectedNode.getAttribute('gclms:node-id')
		});	
		
		parentNode.insert({after: selectedNode});
		GCLMS.ContentController.toggleListClass(selectedNodeList);
		GCLMS.ContentController.toggleListClass(parentNodeList);
		
		GCLMS.ContentController.toggleMenubarButtons();
		GCLMS.ContentController.createSortables();
		
		return false;
	},
	countDescendentLevels: function(li) {
		if(!li.select('li').length) {
			return 0;
		}
		if(!li.select('li li').length) {
			return 1;
		}
		if(!li.select('li li li').length) {
			return 2;
		}
		if(!li.select('li li li li').length) {
			return 3;
		}
		if(!li.select('li li li li li').length) {
			return 4;
		}
		if(!li.select('li li li li li li').length) {
			return 5;
		}
		return 6;
	},
	countAncestorLevels: function(li) {
		var levels = 0;
		do {
			li = li.up('li.gclms-node');
		} while(li && ++levels);
		return levels;
	},
	toggleMenubarButtons: function() {
		$$('.gclms-menubar button').each(function(node){
			node.disable();
		});

		$('convertPageToLabel').down('button').disable();
		$('convertLabelToPage').down('button').disable();

		$('addLabel').down('button').enable();
		$('addPage').down('button').enable();

		var selectedAnchor = $('gclms-nodes').down('li a.selected');
		if(!selectedAnchor) {
			return false;
		}
			
		var selectedNode = selectedAnchor.up('li');
			
		if(!selectedNode || selectedNode.getAttribute('gclms:node-id') == '0') {
			return false;
		}
		
		if(selectedNode.hasClassName('gclms-page')) {
			$('editPage').down('button').enable();
		}	
		
		$('secondaryMenubar').displayAsBlock();

		$('renameNode').down('button').enable();
		
		if(selectedNode.down('li')) {
			$('deleteNode').down('button').disable();
		} else {
			$('deleteNode').down('button').enable();
		}
		
		var ancestorLevels = GCLMS.ContentController.countAncestorLevels(selectedNode);
		var descendentLevels = GCLMS.ContentController.countDescendentLevels(selectedNode);
				
		if(ancestorLevels >= 3) {
			$('addLabel').down('button').disable();
			$('addPage').down('button').disable();
		}
		
		if(selectedNode.previous('li') && ancestorLevels + descendentLevels <= 2) {
			$('increaseIndent').down('button').enable();
		}
			
		if(ancestorLevels >= 1) {
			$('decreaseIndent').down('button').enable();
		}
		
		if (selectedNode.hasClassName('gclms-label')) {
			$('convertLabelToPage').down('button').enable();
			$('convertPageToLabel').down('button').disable();
		} else {
			$('convertPageToLabel').down('button').enable();
			$('convertLabelToPage').down('button').disable();
		}
	},
	createSortables: function() {		
		var nodeSets = [
			$$('#gclms-nodes > ul > li > ul > li > ul > li > ul > li > ul'),
			$$('#gclms-nodes > ul > li > ul > li > ul > li > ul'),
			$$('#gclms-nodes > ul > li > ul > li > ul'),
			$$('#gclms-nodes > ul > li > ul')
		];
		
		nodeSets.each(function(nodeSet){
			nodeSet.each(function(nodes){
				Sortable.create(nodes.getAttribute('id'),{
					containment: nodeSet,
					handle: 'gclms-handle',
					scroll: window,
					dropOnEmpty: true,
					onUpdate: GCLMS.ContentController.reorderNodes
				});					
			});
		});
	},
	reorderNodes: function(ul) {
		if (ul.down('li')) {
			var nodeIds = [];
			$$('#' + ul.getAttribute('id') + ' > li').each(function(node){
				nodeIds.push(node.getAttribute('gclms:node-id'));
			});	
			GCLMS.Node.reorder({
				nodeIds: nodeIds,
				parentNodeId: ul.up('li').getAttribute('gclms:node-id')
			});
		}
		
		GCLMS.ContentController.toggleListClass(ul);
	},
	toggleListClass: function(ul) {
		//If list contains any nodes
		if(ul.down('li')) {
			var parentNode = ul.up('li');
			parentNode.addClassName('gclms-expanded');
			
			try {
				$$('#' + parentNode.getAttribute('id') + ' > ul > li').each(function(node){ //IE croaks on this sometimes
					node.displayAsBlock();
				});
			} catch (e) {}

			parentNode.removeClassName('gclms-collapsed');
		} else {
			ul.up('li').removeClassName('gclms-expanded');
		}
	},
	updateMenubars: function(event) {
		if(self.scrollY > $('gclms-menubars').cumulativeOffset().top) {
			if(!$('gclms-menubars-floater').hasClassName('gclms-floating')) {
				var offsetHeight = $('gclms-menubars').offsetHeight;
				$('gclms-menubars-floater').addClassName('gclms-floating');	
				$('gclms-menubars').setStyle({
					height: offsetHeight + 'px'
				});
			}
		} else {
			$('gclms-menubars-floater').removeClassName('gclms-floating');			
			$('gclms-menubars').setStyle({
				height: ''
			});
		}
	}
};

GCLMS.Node = {
	ajaxUrl: '/' + document.body.getAttribute('gclms:group') + '/' + document.body.getAttribute('gclms:course') + '/content/',
	PAGE_TYPE_INT: 0,
	LABEL_TYPE_INT: 1,	
	add: function(options) {
		var request = new Ajax.Request(this.ajaxUrl + 'add',{
			method: 'post',
			parameters: {
				'data[Node][id]': options.id,
				'data[Node][parent_node_id]': options.parentNodeId,
				'data[Node][title]': options.title,
				'data[Node][type]': options.type
			},
			onComplete: options.callback
		});
	},
	rename: function(options) {
		var request = new Ajax.Request(this.ajaxUrl + 'rename/' + options.id,{
			method: 'post',
			parameters: {
				'data[Node][title]': options.title
			}
		});	
	},
	remove: function(options) {
		var request = new Ajax.Request(this.ajaxUrl + 'delete/' + options.id);
	},
	reorder: function(options) {
		var request = new Ajax.Request(this.ajaxUrl + 'reorder',{
			method: 'post',
			parameters: {
				'data[Node][children_nodes]': options.nodeIds.toString(),
				'data[Node][id]': options.parentNodeId
			}
		});
	},
	convertType: function(options) {
		var request = new Ajax.Request(this.ajaxUrl + 'convert_type/' + options.id,{
			method: 'post',
			parameters: {
				'data[Node][type]': options.type
			}
		});	
	},
	increaseIndent: function(options) {
		var request = new Ajax.Request(this.ajaxUrl + 'increase_indent/' + options.id,{
			method: 'post',
			onComplete: function(request) {
				//alert(request.responseText);
			}
		});	
	},
	decreaseIndent: function(options) {
		var request = new Ajax.Request(this.ajaxUrl + 'decrease_indent/' + options.id,{
			method: 'post',
			onComplete: function(request) {
				//alert(request.responseText);
			}
		});	
	}
};

GCLMS.Views.update({
	node: '<li id="node_#{id}" gclms:node-id="#{id}" class="gclms-node #{typeClass}"> <img class="gclms-expand-button" src="/img/blank-1.png"/><span class="gclms-handle"> <img class="gclms-icon" src="/img/blank-1.png"/> <a href="#">#{title}</a></span><ul id="list_#{id}"></ul></li>'
});

Event.observe(window, 'scroll', GCLMS.ContentController.updateMenubars.bind(this));

GCLMS.Triggers.update({
	'#gclms-nodes' : {
		':loaded': GCLMS.ContentController.initialize,
		'li': {
			'img.gclms-expand-button:click': GCLMS.ContentController.toggleNodeExpansion,
			'img.gclms-icon:click': GCLMS.ContentController.selectNode,
			'a' : {
				':click': GCLMS.ContentController.selectNode,
				':dblclick': GCLMS.ContentController.editPage
			}
		}
	},

	'.gclms-menubar' : {
		'#addLabel:click': GCLMS.ContentController.getLabelTitleForAddition,
		'#addPage:click': GCLMS.ContentController.getPageTitleForAddition,
		'#deleteNode:click': GCLMS.ContentController.confirmDeleteNode,
		'#renameNode:click': GCLMS.ContentController.getNodeTitleForRename,
		'#increaseIndent:click': GCLMS.ContentController.increaseIndent,
		'#decreaseIndent:click': GCLMS.ContentController.decreaseIndent,
		'#convertPageToLabel:click': GCLMS.ContentController.convertPageToLabel,
		'#convertLabelToPage:click': GCLMS.ContentController.convertLabelToPage,
		'#editPage:click': GCLMS.ContentController.editPage
	}
});