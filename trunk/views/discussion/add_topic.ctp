<?
$javascript->link(array(
	'vendors/prototype',
	'prototype_extensions',
	'gclms'
), false);

echo $this->element('no_column_background'); ?>

<div class="gclms-content">
	<div class="gclms-step-back"><a href="<?= $groupAndCoursePath ?>/discussion/forum/<?= $forum['Forum']['id'] ?>"><? __('Cancel and go back') ?></a></div>
	<?= $this->element('notifications'); ?>
	<h1><?= __('Add Topic') ?></h1>    
	<?
	echo $form->create('ForumPost', array('url'=>$groupAndCoursePath . '/discussion/add_topic/forum:' . $forum['Forum']['id']));
	echo $form->hidden('forum_id',array('value'=>$forum['Forum']['id']));
	include('post_form.ctp');
	echo $form->submit(__('Save',true),array('class'=>'gclms-save'));
	echo $form->end();
	?>
</div>