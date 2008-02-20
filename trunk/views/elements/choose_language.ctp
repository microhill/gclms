<div class="gclms-choose-language">
	<?= $form->create('User', array('action' => 'choose_language','id'=>'Usergclms-choose-language'));?>
	<p>
		<img src="/img/permanent/world_map2007-09-13.png" align="absmiddle" />
		<?= $form->select('User.language',$languages, $language, array('escape'=>false),false); ?>
	</p>
	<?= $form->end(); ?>
</div>