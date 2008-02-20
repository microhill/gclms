<?
echo $this->renderElement('menu', array("items" => array(
	array('controller' => 'Courses','label'=>__('Course Catalogue', true),'url'=>'/courses'),
	array('controller' => 'Profile','label'=>__('My Profile', true),'url'=>'/profile'),
	array('controller' => 'Groups','label'=>__('Register Your Group', true),'class'=>'register','url'=>'/groups/register')
)));