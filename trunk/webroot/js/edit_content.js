/*global $, $$, Ajax, Element, GCLMS, Sortable, document, window, self, UUID, __ */

GCLMS.NodesController = {
	initialize: function() {
		$$('#gclms-nodes li.gclms-hidden > ul > li').each(function(li) {
			li.hide();
			li.removeClassName('gclms-hidden');
		});
		$$('#gclms-nodes li.gclms-hidden').each(function(li) {
			li.removeClassName('gclms-hidden');
		});		
		GCLMS.NodesController.createSortables();
	},
	toggleNodeExpansion: function() {
		var li = this.up('li');
		
		if(li.hasClassName('gclms-collapsed')) {
			$$('#' + li.getAttribute('id') + ' > ul > li').each(function(node){
				node.showAsBlock();
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
				GCLMS.NodesController.selectNode.bind(li.down('a'))();
			}
		}
	},
	convertLabelToPage: function() {
		GCLMS.NodesController.convertNodeType(GCLMS.Node.PAGE_TYPE_INT);
	},
	convertPageToLabel: function() {
		GCLMS.NodesController.convertNodeType(GCLMS.Node.LABEL_TYPE_INT);
	},
	convertNodeType: function(type) {
		var li = $$('#gclms-nodes a.selected').first().up('li');
		
		li.toggleClassName('gclms-page');
		li.toggleClassName('gclms-label');
		
		GCLMS.NodesController.toggleMenubarButtons();
		
		GCLMS.Node.convertType({
			id: li.getAttribute('gclms:node-id'),
			type: type
		});	
	},
	editPage: function() {
		var li = $$('#gclms-nodes a.selected').first().up('li');
		if(li.hasClassName('gclms-page')) {
			self.location = '/' + document.body.getAttribute('lms:group') + '/' + document.body.getAttribute('lms:course') + '/pages/edit/' + li.getAttribute('gclms:node-id');
		}
	},
	confirmDeleteNode: function() {
		GCLMS.popup.create({
			text: this.getAttribute('confirm:text'),
			confirmButtonText: __('Yes'),
			cancelButtonText: __('No'),
			type: 'confirm',
			callback: GCLMS.NodesController.deleteNode
		});
		return false;
	},
	deleteNode: function() {
		var li = $$('#gclms-nodes a.selected').first().up('li');

		GCLMS.Node.remove({id: li.getAttribute('gclms:node-id')});
		ul = li.up('ul');
	
		li.remove();

		GCLMS.NodesController.toggleMenubarButtons();
		GCLMS.NodesController.toggleListClass(ul);
	},
	getNodeTitleForRename: function() {
		GCLMS.popup.create({
			text: this.getAttribute('prompt:text'),
			value: $('gclms-nodes').down('a.selected').innerHTML,
			callback: GCLMS.NodesController.renameNode
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
			text: this.getAttribute('prompt:text'),
			callback: GCLMS.NodesController.addLabel
		});
		return false;
	},
	getPageTitleForAddition: function() {
		GCLMS.popup.create({
			text: this.getAttribute('prompt:text'),
			callback: GCLMS.NodesController.addPage
		});
		return false;
	},	
	addLabel: function(title) {
		if(!title) {
			return false;
		}
		GCLMS.NodesController.addNode(title,'label');
	},
	addPage: function(title) {
		if(!title) {
			return false;
		}
		GCLMS.NodesController.addNode(title,'page');
	},
	addNode: function(title,type) {
		var tmpNodeId = UUID.generate();
	
		var ul = GCLMS.NodesController.selectListForNodeAddition();
		var parentNode = ul.up('li.gclms-node');
		var parentNodeId = parentNode ? parentNode.getAttribute('gclms:node-id') : 0;
			
		ul.insert(GCLMS.Views.get('node').interpolate({
			id: tmpNodeId,
			title: title,
			typeClass: 'gclms-' + type,
			randomListId: UUID.generate()
		}));
	
		GCLMS.Node.add({
			parentNodeId: parentNodeId,
			title: title,
			type: type == 'label' ? 1 : 0,
			callback: function(request) {
				$(tmpNodeId).setAttribute('gclms:node-id',request.responseText);
				$(tmpNodeId).observeRules(GCLMS.Triggers.get('#gclms-nodes').li);
				GCLMS.NodesController.createSortables();
		}});
		
		GCLMS.NodesController.toggleListClass(ul);
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
		
		GCLMS.NodesController.toggleMenubarButtons();
		
		return false;
	},
	increaseIndent: function(event) {
		var selectedNode = $('gclms-nodes').down('li a.selected').up('li');
		var selectedNodeList = selectedNode.up('ul');	
		var previousNode = selectedNode.previous('li');
		
		if(!previousNode || GCLMS.NodesController.countAncestorLevels(selectedNode) + GCLMS.NodesController.countDescendentLevels(selectedNode) > 2) {
			return false;
		}

		var previousNodeChildList = previousNode.down('ul');
		
		previousNodeChildList.insert(selectedNode);
		GCLMS.NodesController.toggleListClass(selectedNodeList);
		GCLMS.NodesController.toggleListClass(previousNodeChildList);		
		
		GCLMS.NodesController.toggleMenubarButtons();
		GCLMS.NodesController.createSortables();
		
		GCLMS.Node.changeParent({
			parentNodeId: previousNode.getAttribute('gclms:node-id'),
			id: selectedNode.getAttribute('gclms:node-id')
		});
		
		return false;
	},
	decreaseIndent: function(event) {
		var selectedNode = $('gclms-nodes').down('li a.selected').up('li');
		var selectedNodeList = selectedNode.up('ul');
		var parentNode = selectedNode.up('li');
		var parentNodeList = parentNode.up('ul');
		
		if(!parentNode || GCLMS.NodesController.countAncestorLevels(selectedNode) < 1) {
			return false;
		}
		
		parentNode.insert({after: selectedNode});
		GCLMS.NodesController.toggleListClass(selectedNodeList);
		GCLMS.NodesController.toggleListClass(parentNodeList);
		
		GCLMS.NodesController.toggleMenubarButtons();
		GCLMS.NodesController.createSortables();
		
		GCLMS.Node.changeParent({
			parentNodeId: parentNodeList.up('li').getAttribute('gclms:node-id'),
			id: selectedNode.getAttribute('gclms:node-id')
		});		
		
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
			node.hide();
		});

		$('addLabel').showAsInline();
		$('addPage').showAsInline();

		var selectedAnchor = $('gclms-nodes').down('li a.selected');
		if(!selectedAnchor) {
			return false;
		}
			
		var selectedNode = selectedAnchor.up('li');
		
		if(selectedNode.hasClassName('gclms-page')) {
			$('editPage').showAsInline();
		}		
		
		if(!selectedNode || selectedNode.getAttribute('gclms:node-id') == '0') {
			return false;
		}

		$('renameNode').showAsInline();
		
		if(selectedNode.down('li')) {
			
		} else {
			$('deleteNode').showAsInline();
		}
		
		var ancestorLevels = GCLMS.NodesController.countAncestorLevels(selectedNode);
		var descendentLevels = GCLMS.NodesController.countDescendentLevels(selectedNode);
				
		if(ancestorLevels >= 3) {
			$('addLabel').hide();
			$('addPage').hide();
		}
		
		if(selectedNode.previous('li') && ancestorLevels + descendentLevels <= 2) {
			$('increaseIndent').showAsInline();
		}
			
		if(ancestorLevels >= 1) {
			$('decreaseIndent').showAsInline();
		}
		
		if (selectedNode.hasClassName('gclms-label')) {
			$('convertLabelToPage').showAsInline();
		} else {
			$('convertPageToLabel').showAsInline();
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
					onUpdate: GCLMS.NodesController.reorderNodes
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
		
		GCLMS.NodesController.toggleListClass(ul);
	},
	toggleListClass: function(ul) {
		//If list contains any nodes
		if(ul.down('li')) {
			var parentNode = ul.up('li');
			parentNode.addClassName('gclms-expanded');
			
			$$('#' + parentNode.getAttribute('id') + ' > ul > li').each(function(node){
				node.showAsBlock();
			});
			parentNode.removeClassName('gclms-collapsed');
		} else {
			ul.up('li').removeClassName('gclms-expanded');
		}
	}
};

GCLMS.Node = {
	ajaxUrl: '/' + document.body.getAttribute('lms:group') + '/' + document.body.getAttribute('lms:course') + '/content/',
	PAGE_TYPE_INT: 0,
	LABEL_TYPE_INT: 1,	
	add: function(options) {
		var request = new Ajax.Request(this.ajaxUrl + 'add',{
			method: 'post',
			parameters: {
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
			method: 'post'
		});	
	},
	decreaseIndent: function(options) {
		var request = new Ajax.Request(this.ajaxUrl + 'decrease_indent/' + options.id,{
			method: 'post'
		});	
	}
};

GCLMS.Views.update({
	node: '<li id="#{id}" class="gclms-node #{typeClass}"> <img class="gclms-expand-button" src="/img/blank-1.png"/><span class="gclms-handle"> <img class="gclms-icon" src="/img/blank-1.png"/> <a href="#">#{title}</a></span><ul id="#{randomListId}"></ul></li>'
});

GCLMS.Triggers.update({
	'#gclms-nodes' : {
		':loaded': GCLMS.NodesController.initialize,
		'li': {
			'img.gclms-expand-button:click': GCLMS.NodesController.toggleNodeExpansion,
			'img.gclms-icon:click': GCLMS.NodesController.selectNode,
			'a' : {
				':click': GCLMS.NodesController.selectNode,
				':dblclick': GCLMS.NodesController.editPage
			}
		}
	},

	'.gclms-menubar' : {
		'#addLabel:click': GCLMS.NodesController.getLabelTitleForAddition,
		'#addPage:click': GCLMS.NodesController.getPageTitleForAddition,
		'#deleteNode:click': GCLMS.NodesController.confirmDeleteNode,
		'#renameNode:click': GCLMS.NodesController.getNodeTitleForRename,
		'#increaseIndent:click': GCLMS.NodesController.increaseIndent,
		'#decreaseIndent:click': GCLMS.NodesController.decreaseIndent,
		'#convertPageToLabel:click': GCLMS.NodesController.convertPageToLabel,
		'#convertLabelToPage:click': GCLMS.NodesController.convertLabelToPage,
		'#editPage:click': GCLMS.NodesController.editPage
	}
});