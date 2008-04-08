<div class="gclms-left-column">
	<ul class="gclms-left-column-menu">
		<?= $this->renderElement('menu', array('items' => array(
			array('label'=>__('1. Database', true),'class'=>'gclms-database','active'=>$this->action == 'database','url'=>'/install/database'),
			array('label'=>__('2. Site Configuration', true),'class'=>'gclms-configuration','active'=>$this->action == 'configuration','url'=>'/install/configuration'),
			array('label'=>__('3. First User', true),'class'=>'gclms-first-user','active'=>$this->action == 'first_user','url'=>'/install/first_user')
		)));
		?>
	</ul>
</div>