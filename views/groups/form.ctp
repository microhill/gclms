<?
echo $form->input('name',array(
	'label' =>  __('Group name', true),
	'between' => '<br/>',
	'size' => 30
));
if($this->name != 'Configuration') {
	echo $form->input('web_path',array(
		'label' =>  __('Web path',true) . ' <img class="gclms-tooltip-button" src="/img/icons/oxygen/16x16/actions/dialog-information.png" tooltip:text="'.__('This is part of what makes up the web address of a group on', true).' ' . Configure::read('Site.name') . '. '.__('It can be made up of lower case letters, numbers, or hypens. The end result will be something like', true).': <br/><br/>' . Configure::read('Site.domain') . '<strong>web-path</strong>" /> ',
		'between' => '<br/>'
	));
}
echo $form->input('phone',array(
	'label' =>  __('Phone', true),
	'between' => '<br/>'
));
echo $form->input('address_1',array(
	'label' =>  __('Address 1', true),
	'between' => '<br/>'
));
echo $form->input('address_2',array(
	'label' =>  __('Address 2', true),
	'between' => '<br/>'
));
echo $form->input('city',array(
	'label' =>  __('City', true),
	'between' => '<br/>'
));
echo $form->input('state',array(
	'label' =>  __('State', true),
	'between' => '<br/>'
));
echo $form->input('postal_code',array(
	'label' =>  __('Postal code', true),
	'between' => '<br/>'
));

echo $form->label('logo',__('Logo', true)) . '<br/>';
if($this->data['Group']['logo']): ?>
	<button id="gclms-clear-group-logo">Clear existing logo</button>
<? endif;

echo $form->input('logo',array(
	'label' =>  false,
	'type' => 'file',
	'div' => false,
	'class' => empty($this->data['Group']['logo']) ? '' : 'hidden'
));

echo $form->input('external_web_address',array(
	'label' =>  __('External web address',true) . ' <img class="gclms-tooltip-button" src="/img/icons/oxygen/16x16/actions/dialog-information.png" tooltip:text="'.__('This should be the organization\'s official web site. If a group is named \'My Organization\', its external web address might be', true).': <br/><br/><strong>http://www.MyOrganization.com</strong>" /> ',
	'between' => '<br/>'
));

echo $form->input('description',array(
	'rows' => 12,
	'cols' => 110,
	'label' => __('Description',true),
	'between' => '<br/>'
));


if($this->action != 'register') {
	echo $form->input('css',array(
		'rows' => 12,
		'cols' => 100,
		'label' => __('Custom CSS',true),
		'between' => '<br/>'
	));

	echo $form->input('grade_display',array(
		'label' =>  __('Final Grade Display', true),
		'between' => '<br/>',
		'options' => array('Pass / Fail','Percentage','X / Y')
	));

	function customizeCellData($row,$helpers) {
		$row['full_name'] = $row['first_name'] . ' ' . $row['last_name'];
		
		return $row;
	}
		
	echo '<div>';
	if(!empty($data['GroupAdministrators'])) {
		echo $form->label('Group.Administrators', 'Group Administrators') . '<br/>';
		echo $this->renderElement('mini_recordset', array('data' => $data['GroupAdministrators'],'model'=>'GroupAdministrator','dataCustomizer'=>'customizeCellData','headers'=>array(
				__('Username',true),__('Name',true),__('Email',true)
			),'fields'=>array(
				'username','full_name','email'
			)));
	}
	echo '</div>';
}
?>
<script type="text/javascript" src="/js/tinymce/tiny_mce.js"></script>