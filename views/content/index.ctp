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
		<div id="gclms-menubars">
			<div id="gclms-menubars-floater">
				<?
				echo $this->renderElement('menubar',array('buttons' => array(
					array(
						'id' => 'addPage',
						'class' => 'add',
						'label' => '<u>A</u>dd Page',
						'strings' => array(
							'prompt:text' => 'Enter the name of the page:'
						),
						'accesskey' => 'a'
					),
					array(
						'id' => 'addLabel',
						'class' => 'add',
						'label' => 'Add <u>L</u>abel',
						'strings' => array(
							'prompt:text' => 'Enter the name of the label:'
						),
						'accesskey' => 'l'
					),
					array(
						'id' => 'convertPageToLabel',
						'class' => 'label',
						'label' => '<u>C</u>onvert to Label',
						'accesskey' => 'c',
						'disabled' => 'disabled'
					),
					array(
						'id' => 'convertLabelToPage',
						'class' => 'page',
						'label' => '<u>C</u>onvert to Page',
						'accesskey' => 'c',
						'disabled' => 'disabled'
					)
				)));
				
				echo $this->renderElement('menubar',array('id' => 'secondaryMenubar','buttons' => array(
					array(
						'id' => 'decreaseIndent',
						'class' => 'decreaseIndent',
						'label' => 'Decrease Indent',
						'disabled' => 'disabled'
					),
					array(
						'id' => 'increaseIndent',
						'class' => 'increaseIndent',
						'label' => 'Increase Indent',
						'disabled' => 'disabled'
					),
					array(
						'id' => 'renameNode',
						'class' => 'rename',
						'label' => '<u>R</u>ename',
						'strings' => array(
							'prompt:text' => 'Enter the new name:'
						),
						'accesskey' => 'r',
						'disabled' => 'disabled'
					),
					array(
						'id' => 'deleteNode',
						'class' => 'delete',
						'label' => '<u>D</u>elete',
						'strings' => array(
							'notempty:text' => 'Must be empty before deletion.',
							'confirm:text' => 'Are you sure you want to delete this?'
						),
						'accesskey' => 'd',
						'disabled' => 'disabled'
					),
					array(
						'id' => 'editPage',
						'class' => 'edit',
						'label' => '<u>E</u>dit',
						'accesskey' => 'e',
						'disabled' => 'disabled'
					))
				));
				?>
			</div>
		</div>

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