<?
$html->css('edit_content', null, null, false);

$javascript->link(array(
	'vendors/prototype',
	'prototype_extensions',
	'gclms',
	'vendors/uuid',
	'vendors/scriptaculous1.8.1/scriptaculous',
	'vendors/scriptaculous1.8.1/dragdrop',
	'edit_content'
), false);

echo $this->renderElement('left_column');
?>
		
<div class="gclms-center-column">
	<div class="gclms-content">	
		<div id="gclms-spinner"><img src="/img/permanent/spinner2007-09-14.gif" alt="Spinner" /></div>
		<h1><? __('Course Structure') ?> </h1>
		<div id="gclms-menubars">
			<div id="gclms-menubars-floater">
				<?
				echo $this->renderElement('menubar',array('buttons' => array(
					array(
						'id' => 'addPage',
						'class' => 'add',
						'label' => '<u>A</u>dd Page',
						'strings' => array(
							'gclms:prompt-text' => 'Enter the name of the page:'
						),
						'accesskey' => 'a'
					),
					array(
						'id' => 'addLabel',
						'class' => 'add',
						'label' => 'A<u>d</u>d Label',
						'strings' => array(
							'gclms:prompt-text' => 'Enter the name of the label:'
						),
						'accesskey' => 'd'
					),
					array(
						'id' => 'convertPageToLabel',
						'class' => 'label',
						'label' => 'Convert to <u>L</u>abel',
						'accesskey' => 'l',
						'disabled' => 'disabled'
					),
					array(
						'id' => 'convertLabelToPage',
						'class' => 'page',
						'label' => 'Convert to <u>P</u>age',
						'accesskey' => 'p',
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
							'gclms:prompt-text' => 'Enter the new name:'
						),
						'accesskey' => 'r',
						'disabled' => 'disabled'
					),
					array(
						'id' => 'deleteNode',
						'class' => 'delete',
						'label' => 'Dele<u>t</u>e',
						'strings' => array(
							'gclms:notempty-text' => 'Must be empty before deletion.',
							'gclms:confirm-text' => 'Are you sure you want to delete this?'
						),
						'accesskey' => 't',
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

		<div id="gclms-nodes" class="gclms-nodes gclms-expandable-list">
			<ul id="<?= String::uuid() ?>">
				<li gclms:node-id="0" class="gclms-course">
					<img class="gclms-icon" src="/img/blank-1.png" alt="Icon" />
					<span>
						<img class="gclms-icon" src="/img/blank-1.png" alt="Icon" />
						<a href="#"><?= $course['title'] ?></a>
					</span>		
					<?
					echo $this->renderElement('nodes_edit_tree',array(
						'nodes' => $this->data,
					));
					?>	
				</li>
			</ul>
		</div>
	</div>
</div>

<?= $this->renderElement('right_column'); ?>