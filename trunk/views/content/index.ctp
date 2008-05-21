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

echo $this->element('left_column');
?>
		
<div class="gclms-center-column">
	<div class="gclms-content">	
		<div id="gclms-spinner"><img src="/img/permanent/spinner2007-09-14.gif" alt="Spinner" /></div>
		<h1><? __('Course Structure') ?> </h1>
		<div id="gclms-menubars">
			<div id="gclms-menubars-floater">
				<?
				echo $this->element('menubar',array('buttons' => array(
					array(
						'id' => 'addPage',
						'class' => 'gclms-add',
						'label' => '<u>A</u>dd Page',
						'strings' => array(
							'gclms:prompt-text' => 'Enter the name of the page:'
						),
						'accesskey' => 'a'
					),
					array(
						'id' => 'addLabel',
						'class' => 'gclms-add',
						'label' => 'A<u>d</u>d Label',
						'strings' => array(
							'gclms:prompt-text' => 'Enter the name of the label:'
						),
						'accesskey' => 'd'
					),
					array(
						'id' => 'convertPageToLabel',
						'class' => 'gclms-label',
						'label' => 'Convert to <u>L</u>abel',
						'accesskey' => 'l',
						'disabled' => 'disabled'
					),
					array(
						'id' => 'convertLabelToPage',
						'class' => 'gclms-page',
						'label' => 'Convert to <u>P</u>age',
						'accesskey' => 'p',
						'disabled' => 'disabled'
					)
				)));
				
				echo $this->element('menubar',array('id' => 'secondaryMenubar','buttons' => array(
					array(
						'id' => 'decreaseIndent',
						'class' => 'gclms-decrease-indent',
						'label' => 'Decrease Indent',
						'disabled' => 'disabled'
					),
					array(
						'id' => 'increaseIndent',
						'class' => 'gclms-increase-indent',
						'label' => 'Increase Indent',
						'disabled' => 'disabled'
					),
					array(
						'id' => 'renameNode',
						'class' => 'gclms-rename',
						'label' => '<u>R</u>ename',
						'strings' => array(
							'gclms:prompt-text' => 'Enter the new name:'
						),
						'accesskey' => 'r',
						'disabled' => 'disabled'
					),
					array(
						'id' => 'deleteNode',
						'class' => 'gclms-delete',
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
						'class' => 'gclms-edit',
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
					if(!empty($this->data))
						display_nodes($this->data,1,$groupAndCoursePath);
					else
						echo '<ul id="' . String::uuid() . '"></ul>';
					
					function display_nodes($nodes,$level = 1,$groupAndCoursePath) {
						if($level > 4) {
							return false;
						}
						
						echo '<ul id="' . String::uuid() . '">';
						
						foreach($nodes as $node) {
							echo '<li id="node_' . $node['id'] . '" gclms:node-id="' . $node['id'] . '" class="gclms-node';			 
							
							if(!empty($node['ChildNode'])) {
								if($level < 1)
									echo ' gclms-expanded';	
								else
									echo ' gclms-collapsed gclms-hidden';	
							} else {
								echo ' gclms-empty';
							}
							
							echo $node['type'] ? ' gclms-label' : ' gclms-page'; 
							echo '">';
					
							echo '<img class="gclms-expand-button" src="/img/blank-1.png" alt="Icon" /> ';
							echo '<span class="gclms-handle">';
								echo '<img class="gclms-icon" src="/img/blank-1.png" alt="Icon" />';
							
							echo ' <a href="' . $groupAndCoursePath . '/pages/edit/' . $node['id'] . '">' . $node['title'] . '</a>';
								
							echo '</span>';
								
							if(!empty($node['ChildNode']))
								display_nodes($node['ChildNode'],$level + 1,$groupAndCoursePath);
							else
								echo '<ul id="' . String::uuid() . '"></ul>';
								
							echo "</li>\n";
						}
						
						echo '</ul>';
					}
					?>
				</li>
			</ul>
		</div>
	</div>
</div>

<?= $this->element('right_column'); ?>