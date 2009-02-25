<?
$html->css('edit_content', null, null, false);

$javascript->link(array(
	'vendors/prototype1.6.0.3',
	'vendors/prototype_extensions1.0',
	'gclms',
	'vendors/uuid1.0',
	'vendors/scriptaculous1.8.1/effects',
	'vendors/scriptaculous1.8.1/dragdrop',
	'edit_content',
	'popup'
), false);

echo $this->element('left_column');
?>
		
<div class="gclms-center-column">
	<div class="gclms-content">	
		<div id="gclms-spinner"><img src="/img/permanent/spinner2007-09-14.gif" alt="Spinner" /></div>
		<h1><? __('Lesson Structure') ?> </h1>
		<div id="gclms-menubars">
			<div id="gclms-menubars-floater">
				<?
				echo $this->element('menubar',array('buttons' => array(
					array(
						'id' => 'addPage',
						'class' => 'gclms-add',
						'label' => __('Add Page',true),
						'strings' => array(
							'gclms:prompt-text' => __('Enter the name of the page:',true)
						),
						'accesskey' => 'a'
					),
					array(
						'id' => 'addLabel',
						'class' => 'gclms-add',
						'label' => __('Add Label',true),
						'strings' => array(
							'gclms:prompt-text' => __('Enter the name of the label:',true)
						),
						'accesskey' => 'd'
					),
					array(
						'id' => 'convertPageToLabel',
						'class' => 'gclms-label',
						'label' => __('Convert to Label',true),
						'accesskey' => 'l',
						'disabled' => 'disabled'
					),
					array(
						'id' => 'convertLabelToPage',
						'class' => 'gclms-page',
						'label' => __('Convert to Page',true),
						'accesskey' => 'p',
						'disabled' => 'disabled'
					)
				)));
				
				echo $this->element('menubar',array('id' => 'secondaryMenubar','buttons' => array(
					array(
						'id' => 'decreaseIndent',
						'class' => 'gclms-decrease-indent',
						'label' => __('Decrease Indent',true),
						'disabled' => 'disabled'
					),
					array(
						'id' => 'increaseIndent',
						'class' => 'gclms-increase-indent',
						'label' => __('Increase Indent',true),
						'disabled' => 'disabled'
					),
					array(
						'id' => 'renameNode',
						'class' => 'gclms-rename',
						'label' => __('Rename',true),
						'strings' => array(
							'gclms:prompt-text' => __('Enter the new name:',true)
						),
						'accesskey' => 'r',
						'disabled' => 'disabled'
					),
					array(
						'id' => 'deleteNode',
						'class' => 'gclms-delete',
						'label' => __('Delete',true),
						'strings' => array(
							'gclms:notempty-text' => __('Must be empty before deletion.',true),
							'gclms:confirm-text' => __('Are you sure you want to delete this?',true)
						),
						'accesskey' => 't',
						'disabled' => 'disabled'
					),
					array(
						'id' => 'editPage',
						'class' => 'gclms-edit',
						'label' => __('Edit',true),
						'accesskey' => 'e',
						'disabled' => 'disabled'
					))
				));
				?>
			</div>
		</div>

		<div id="gclms-nodes" class="gclms-nodes gclms-expandable-list">
			<ul id="<?= String::uuid() ?>">
				<li gclms-node-id="0" class="gclms-course">
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
							echo '<li id="node_' . $node['id'] . '" gclms-node-id="' . $node['id'] . '" class="gclms-node';			 
							
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