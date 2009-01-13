<?
echo $form->hidden('group_id',array('value'=>Group::get('id')));

echo $form->input('name',array(
	'label' =>  __('Name', true),
	'between' => '<br/>'
));

echo $form->input('course_id',array(
	'label' =>  __('Course', true),
	'between' => '<br/>'
));

echo $form->radio('facilitated',
	array('1' => 'Yes', '0' => 'No'),
	array(
		'legend' =>  __('Will the class be guided by a facilitator?',true),
		'separator' => '<br />',
			'value' => empty($this->data['VirtualClass']['facilitated']) ? '0' : '1'
	)
);

echo '<fieldset>';
	echo '<legend>' . __('Does the class have a definite start and end date?',true) . '</legend>';
	echo '<div>';
	echo $form->radio('has_start_and_end_date',
		array('1' => 'Yes', '0' => 'No'),
		array(
			'legend' =>  false,
			'separator' => '<br />',
			'value' => empty($this->data['VirtualClass']['start']) ? '0' : '1'
		)
	);
	echo '</div>';
	
	echo '<div id="gclms-start-date-div" ' . (empty($this->data['VirtualClass']['start']) ? 'style="display: none;"' : '') .'>';
	echo '<label>'.__('Start date').'</label><br/>';
	echo $myForm->date('start',null,null,false);
	echo '</div>';
	
	echo '<div id="gclms-end-date-div" ' . (empty($this->data['VirtualClass']['start']) ? 'style="display: none;"' : '') . '>';
	echo '<label>'.__('End date').'</label><br/>';
	echo $myForm->date('end',null,null,false);
	echo '</div>';
echo '</fieldset>';

echo '<fieldset>';
	echo '<legend>' . __('Does the class have an enrollment deadline?',true) . '</legend>';
	echo '<div>';
	echo $form->radio('has_enrollment_deadline',
		array('1' => 'Yes', '0' => 'No'),
		array(
			'legend' =>  false,
			'separator' => '<br />',
			'value' => empty($this->data['VirtualClass']['enrollment_deadline']) ? '0' : '1'
		)
	);
	echo '</div>';	
	
	echo '<div id="gclms-enrollment-deadline-div" ' . (empty($this->data['VirtualClass']['enrollment_deadline']) ? 'style="display: none;"' : '') . '>';
	echo '<label>'.__('Enrollment deadline').'</label><br/>';
	echo $myForm->date('enrollment_deadline',null,null,false);
	echo '</div>';
echo '</fieldset>';

if(!empty($this->data['VirtualClass']['time_limit_years']) ||
		!empty($this->data['VirtualClass']['time_limit_months']) ||
		!empty($this->data['VirtualClass']['time_limit_days'])) {
	$this->data['VirtualClass']['has_student_time_limit'] = 1;
} else {
	$this->data['VirtualClass']['has_student_time_limit'] = 0;
}

echo '<fieldset' . (empty($this->data['VirtualClass']['start']) ? ' style="display: none;"' : '') . ' id="time-limit-fieldset">';
	echo '<legend>' . __('Are students given limited time to complete the class?',true) . '</legend>';
	echo '<div>';
	echo $form->radio('has_student_time_limit',
		array('1' => 'Yes', '0' => 'No'),
		array(
			'legend' =>  false,
			'separator' => '<br />',
			'value' => empty($this->data['VirtualClass']['has_student_time_limit']) ? '0' : '1'
		)
	);
	echo '</div>';
	
	echo $form->input('time_limit_years',array(
		'options' => range(0,5),
		'between' => '<br />',
		'label' => __('Years',true),
		'div' => array('style' => empty($this->data['VirtualClass']['has_student_time_limit']) ? 'display: none;' : '')
	));
	
	echo $form->input('time_limit_months',array(
		'options' => range(0,12),
		'between' => '<br />',
		'label' => __('Months',true),
		'div' => array('style' => empty($this->data['VirtualClass']['has_student_time_limit']) ? 'display: none;' : '')
	));
	
	echo $form->input('time_limit_days',array(
		'options' => range(0,30),
		'between' => '<br />',
		'label' => __('Days',true),
		'div' => array('style' => empty($this->data['VirtualClass']['has_student_time_limit']) ? 'display: none;' : '')
	));
echo '</fieldset>';

echo $form->input('capacity',array(
	'label' =>  __('Max capacity (leave blank or set to 0 for no limit)', true),
	'between' => '<br/>',
	'size' => 4
));
