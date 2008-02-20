<?
echo $form->input('alias',array(
	'label' =>  __('Alias', true),
	'between' => '<br/>'
));
echo $form->input('course_id',array(
	'label' =>  __('Course', true),
	'between' => '<br/>',
	'options' => $available_courses
));

echo $form->radio('type',
	array('1' => 'Online', '2' => 'In-person'),
	array(
		'legend' =>  __('How is this class facilitated?',true),
		'class' => 'allowRedistribution',
		'separator' => '<br />'
	)
);

echo '<div>';
echo '<label>'.__('Enrollment deadline').'</label><br/>';
echo $myForm->date('enrollment_deadline',null,null,false);
echo '</div>';

echo '<div>';
echo '<label>'.__('Begin date').'</label><br/>';
echo $myForm->date('beginning',null,null,false);
echo '</div>';

echo '<div>';
echo '<label>'.__('End date').'</label><br/>';
echo $myForm->date('end',null,null,false);
echo '</div>';

echo $form->input('capacity',array(
	'label' =>  __('Max capacity (leave blank for no limit)', true),
	'between' => '<br/>',
	'size' => 4
));
