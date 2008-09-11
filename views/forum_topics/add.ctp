<?
$javascript->link(array(
	'vendors/prototype1.6.0.2',
	'prototype_extensions1.0',
	'gclms'
), false);

echo $this->element('no_column_background'); ?>

<div class="gclms-content">
	<div class="gclms-step-back"><a href="<?= $groupAndCoursePath ?>/forums/forum/<?= $forum['Forum']['id'] ?><?= $framed_suffix ?>"><? __('Cancel and go back') ?></a></div>
	<?= $this->element('notifications'); ?>
	<h1><?= __('Add Topic') ?></h1>    
	<?
	echo $form->create('ForumPost', array('url'=>$groupAndCoursePath . '/forum_topics/add/forum:' . $forum['Forum']['id'] . $framed_suffix));
	echo $form->hidden('forum_id',array('value'=>$forum['Forum']['id']));
	include('form.ctp');
	echo $form->submit(__('Save',true),array('class'=>'gclms-save'));
	echo $form->end();
	?>
</div>