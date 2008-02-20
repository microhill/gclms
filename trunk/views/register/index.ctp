<? echo $this->renderElement('no_column_background'); ?>
<div class="gclms-content">
	<?= $this->renderElement('notifications'); ?>
	<h1><?= __('Register') ?></h1>    
	<?
	echo $form->create('User', array('url' => '/register','autocomplete'=>'off'));
	echo $form->input('new_username',array(
		'label' =>  __('Username', true),
		'between' => '<br/>'
	));
	echo $form->input('new_password',array(
		'label' =>  __('Password', true),
		'between' => '<br/>'
	));
	echo $form->input('repeat_new_password',array(
		'label' =>  __('Repeat Password', true),
		'between' => '<br/>'
	));
	echo $form->input('email',array(
		'label' =>  __('Email', true),
		'between' => '<br/>'
	));
	echo $form->input('first_name',array(
		'label' =>  __('First Name', true),
		'between' => '<br/>'
	));
	echo $form->input('last_name',array(
		'label' =>  __('Last Name', true),
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
		'label' =>  __('Postal Code', true),
		'between' => '<br/>'
	));
	
	echo '<p>';
	echo $form->checkbox('mailing_list');
	echo $form->label('mailing_list',__('Add me to the InternetSeminary.org mailing list.',true),null);
	echo '</p>';	
	
	echo $form->submit(__('Register',true),array('class'=>'Save'));
	echo $form->end();
	?>
</div>