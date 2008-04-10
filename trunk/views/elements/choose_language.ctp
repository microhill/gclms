<div class="gclms-choose-language">
	<?= $form->create('User', array('action' => 'choose_language','id'=>'gclms-choose-language','url' => '/users/choose_language'));?>
	<p>
		<img src="/img/permanent/world_map2007-09-13.png" align="absmiddle" />
		<?= $form->select('User.language',$languages, Configure::read('Config.language'), array('escape'=>false),false); ?>
	</p>
	<?= $form->end(); ?>
</div>