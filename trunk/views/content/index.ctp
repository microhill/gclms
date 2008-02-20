<?
$javascript->link(array(
	'vendors/prototype',
	'prototype_extensions',
	'gclms',
	'vendors/uuid',
	'vendors/scriptaculous1.8/scriptaculous',
	'vendors/scriptaculous1.8/dragdrop',
	'edit_content'
), false);

echo $this->renderElement('left_column');
?>
		
<div class="gclms-center-column">
	<div class="gclms-content">	
		<div id="gclms-spinner"><img src="/img/permanent/spinner2007-09-14.gif"/></div>
		<h1><? __('Course Content') ?> </h1>
		<?
		echo $this->renderElement('menubar',array('buttons' => array(
			array(
				'id' => 'addPage',
				'class' => 'add',
				'label' => 'Add Page',
				'strings' => array(
					'prompt:text' => 'Enter the name of the page:'
				)
			),
			array(
				'id' => 'addLabel',
				'class' => 'add',
				'label' => 'Add Label',
				'strings' => array(
					'prompt:text' => 'Enter the name of the label:'
				)
			),
			array(
				'id' => 'convertPageToLabel',
				'class' => 'convert',
				'label' => 'Convert to Label'
			),
			array(
				'id' => 'convertLabelToPage',
				'class' => 'convert',
				'label' => 'Convert to Page'
			),
			array(
				'id' => 'decreaseIndent',
				'class' => 'decreaseIndent',
				'label' => 'Decrease Indent'
			),
			array(
				'id' => 'increaseIndent',
				'class' => 'increaseIndent',
				'label' => 'Increase Indent'
			),
			array(
				'id' => 'renameNode',
				'class' => 'rename',
				'label' => 'Rename',
				'strings' => array(
					'prompt:text' => 'Enter the new name:'
				)
			),
			array(
				'id' => 'deleteNode',
				'class' => 'delete',
				'label' => 'Delete',
				'strings' => array(
					'notempty:text' => 'Must be empty before deletion.',
					'confirm:text' => 'Are you sure you want to delete this?'
				)
			),
			array(
				'id' => 'editPage',
				'class' => 'edit',
				'label' => 'Edit'
			))
		));
		?>
		<div id="gclms-nodes" class="gclms-nodes">
			<ul id="<?= String::uuid() ?>">
				<li gclms:node-id="0" class="gclms-course">
					<img class="gclms-icon" src="/img/blank-1.png"/>
					<span>
						<img class="gclms-icon" src="/img/blank-1.png"/>
						<a href="#"><?= $course['title'] ?></a>
					</span>		
					<?
					echo $this->renderElement('nodes_list',array(
						'nodes' => $this->data,
						'parent_node_id' => 0,
						'level' => 1
					));
					?>	
				</li>
			</ul>
		</div>
	</div>
</div>

<?= $this->renderElement('right_column'); ?>