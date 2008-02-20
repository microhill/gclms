<div class="gclms-content">
	<h1><?= __('Add Announcement') ?></h1>    
		<?
		echo $form->create('NewsItem',array('id' => null,'url'=> $groupAndCoursePath .  '/announcements/save/0/course:' . $courseWebPath . '/section:' . $facilitated_class['id']));
		echo $form->hidden('course_id',array('value'=>$course['id']));
		include('form.ctp');
		echo $form->submit(__('Save',true),array('class'=>'Save'));
		echo $form->end();
		?>
	</div>
</div>