<?
echo $form->input('username',array(
	'label' =>  __('Username', true),
	'between' => '<br/>'
));

echo $form->input('course_id',array(
	'label' =>  __('Courses', true),
	'between' => '<br/>',
	'options' => $courses,
	'empty' => true,
	//'selected' => @$data['GroupAdministrator']['group_id']
));

echo '<div>';
echo '<label>'.__('How is this class facilitated?').'</label><br/>';
echo $form->radio('type',array(
	'Online','In-person',
	),'<br/>',array('label' =>  __('Courses', true))
);
echo '</div>';

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
