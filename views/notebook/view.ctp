<?
$html->css('notebook', null, null, false);

$javascript->link(array(
	'vendors/prototype',
	'prototype_extensions',
	'gclms',
	'vendors/uuid',
	'vendors/tinymce3.1.0.1/tiny_mce',
	'notebook'
), false);

echo $this->element('left_column'); ?>
		
<div class="gclms-center-column">
	<div class="gclms-content">
		<div class="gclms-step-back"><a href="/notebook"><? __('Notebook') ?></a></div>
		<div class="gclms-notebook-entry">
			<h1><a href="<?= $groupAndCoursePath ?>/notebook/view/<?= $this->data['NotebookEntry']['id'] ?>"><?= $this->data['NotebookEntry']['title'];?></a></h1>
			<p class="gclms-notebook-entry-modified"><?= $myTime->niceShortDate($this->data['NotebookEntry']['modified']) ?></p>
			<?= $this->data['NotebookEntry']['content'] ?>
		</div>

		<? if(!empty($archive)): ?>
			<div id="gclms-notebook-archive">
				<h2><? __('Archive') ?></h2>
				<ul>
					<? foreach($archive as $entry): ?>
						<li class="gclms-notebook-entry" id="<?= $entry['NotebookEntry']['id'] ?>">
							<a href="/notebook/view/<?= $entry['NotebookEntry']['id'] ?>" title="Last modified: <?= $myTime->niceShortDate($entry['NotebookEntry']['modified']) ?>"><?= $entry['NotebookEntry']['title'];?></a>
						</li>
					<? endforeach; ?>
				</ul>
			</div>
		<? endif; ?>
		
		<p>
			<a href="/notebook/edit/<?= $this->data['NotebookEntry']['id'] ?>" class="gclms-edit-notebook-entry"><?= __('Edit') ?></a>
		</p>
				
		<? if(!empty($entry['NotebookEntry']['private'])): ?>
			<? if(!empty($this->data['NotebookEntryComment'])): ?>
				<h2><? __('Comments') ?></h2>
				<div class="gclms-notebook-entry-comments">
					<? foreach($this->data['NotebookEntryComment'] as $comment): ?>
						<div class="gclms-notebook-entry-comment">
							<p>Posted by <?= $comment['User']['alias'] ?> at <?= $comment['created'] ?></p>
							<?= $comment['content'] ?>
						</div>
					<? endforeach; ?>
				</div>
			<? endif; ?>

			<h2 id="comments"><? __('Leave a comment') ?></h2>
			
			<?= $form->create('NotebookEntryComment',array(
				'url' => '/notebook/add_comment',
				'class' => 'gclms-add-comment'
			)); ?>
				<?= $form->hidden('notebook_entry_id',array(
					'value' => $this->data['NotebookEntry']['id']
				)); ?>
				<?= $form->input('content',array(
					'label' =>'',
					'rows' => 10,
					'cols' => 60,
					'class' => 'gclms-comment-content',
					'label' => false
				)); ?>
				<?= $this->element('buttons',array('buttons' => array(
					array(
						'text' => __('Submit Comment',true),
						'hover_color' => 'green',
						'class' => 'gclms-submit'
					)
				)));
				?>
			<?= $form->end(); ?>
		<? endif; ?>
	</div>
</div><?= $this->element('right_column'); ?>