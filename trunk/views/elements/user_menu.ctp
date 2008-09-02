<?= $this->element('menu', array("items" => array(
	array('controller' => 'Courses','class'=>'gclms-courses','label'=>__('Course Catalogue', true),'url'=>'/courses'),
	array('controller' => 'Profile','class'=>'gclms-profile','label'=>__('My Profile', true),'url'=>'/profile'),
	//array('controller' => 'Groups','label'=>__('Register Your Group', true),'class'=>'gclms-register','url'=>'/groups/register')
)));