<div class="gclms-content">
	<?= $this->element('notifications'); ?>
	<h1><? __('Your Profile') ?></h1>    
	<?
	echo $form->create('User', array('url' => '/profile'));

	/*
	echo $form->input('username',array(
		'label' =>  __('Username', true),
		'disabled'=>'disabled',
		'between' => '<br/>',
		'autocomplete' => 'off'
	));
	*/
	
	echo $form->input('first_name',array(
		'label' =>  __('First name', true),
		'between' => '<br/>',
		'autocomplete' => 'off'
	));
	echo $form->input('last_name',array(
		'label' =>  __('Last name', true),
		'between' => '<br/>'
	));
	echo $form->input('hide_full_name',array(
		'label' =>  __('Display full name', true),
		'between' => '<br/>'
	));
	echo $form->input('new_password',array(
		'label' =>  __('New password', true),
		'between' => '<br/>',
		'value' => @$this->data['User']['new_password']
	));
	echo $form->input('repeat_new_password',array(
		'label' =>  __('Repeat new password', true),
		'between' => '<br/>',
		'value' => @$this->data['User']['repeat_new_password']
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
	
	echo '<p>';
	echo $form->checkbox('mailing_list');
	echo $form->label('mailing_list',__('Add me to the InternetSeminary.org mailing list.',true),null);
	echo '</p>';
	
	echo $form->submit(__('Save',true),array('class'=>'gclms-save'));
	echo $form->end();
	?>
</div>