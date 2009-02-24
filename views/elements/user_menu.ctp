<? //$this->element('menu', array("items" => array(
	//array('controller' => 'Courses','class'=>'gclms-courses','label'=>__('Course Catalogue', true),'url'=>'/courses'),
	//array('controller' => 'Profile','class'=>'gclms-profile','label'=>__('My Profile', true),'url'=>'/profile'),
	//array('controller' => 'Groups','label'=>__('Register Your Group', true),'class'=>'gclms-register','url'=>'/groups/register')
//)));
?>

<?
$menu->addMenu(array(
	'name' => 'navigation',
	'label' => __('Navigation',true),
	'section' => 'primary_column'
));

$menu->addMenuItem('navigation',array(
	'label' => __('Course Catalogue', true),
	'class' => 'gclms-courses',
	'active' => $this->name == 'Courses' && $this->action != 'index',
	'url' => '/courses'
));


$menu->addMenuItem('navigation',array(
	'label' => __('My Profile', true),
	'class' => 'gclms-profile',
	'active' => $this->name == 'Courses' && $this->action != 'index',
	'url' => '/profile'
));