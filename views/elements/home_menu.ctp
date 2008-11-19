<ul class="gclms-primary-column-menu">
	<?= $this->element('menu', array("items" => array(
			array('controller' => 'Courses','class'=>'gclms-courses','label'=> __('Course Catalogue', true),'url'=>'/courses'),
			User::get('id') ? null : array('controller' => 'Register','class'=>'gclms-register','label'=> __('Register as New Student', true),'url'=>'/register'),
			Permission::check('*') ? array('controller'=>'administration','url' => '/administration','label'=>__('Site Administration', true),'class'=>'gclms-administration') : null
		)));
	?>
</ul>