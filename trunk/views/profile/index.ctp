<?
$html->css('edit_profile', null, null, false);

$javascript->link(array(
	'vendors/prototype1.6.0.3',
	'vendors/prototype_extensions1.0',
	'gclms',
	'popup',
	'edit_profile'
), false);
?>
<div class="gclms-content">
	<?= $this->element('notifications'); ?>
	<h1><? echo sprintf(__("%s's Profile",true),$this->data['User']['username']) ?></h1>    
	<?	
	echo $form->create('User', array('url' => '/profile','type' => 'file'));
	/*
	echo $form->input('username',array(
		'label' =>  __('Username', true),
		'disabled'=>'disabled',
		'between' => '<br/>',
		'autocomplete' => 'off'
	));
	*/
	?>
	<p class="gclms-profile">
	<?
	if(empty($this->data['User']['avatar']) || $this->data['User']['avatar'] == 'default') {
		?><img src="/img/icons/oxygen_refit/96x96/actions/stock_people.png" /><?
	} else if ($this->data['User']['avatar'] == 'gravatar'){
		?><img src="http://www.gravatar.com/avatar.php?gravatar_id=<?= md5($this->data['User']['email']) ?>&size=96" /><?
	} else if ($this->data['User']['avatar'] == 'upload'){
		?><img src="http://<?= $bucket ?>.s3.amazonaws.com/avatars/<?= $this->data['User']['id'] ?>.jpg" /><?
	}
	?> <button id="gclms-change-picture"><? __('Change Picture') ?></button>
	</p>
	<fieldset id="gclms-avatar-chooser" class="gclms-hidden">
		<legend><? __('Change Picture') ?></legend>
		<p>
			<?
			$this->data['User']['avatar'] = empty($this->data['User']['avatar']) ? 'default' : $this->data['User']['avatar'];
			echo $form->radio('avatar',array('upload' => __('Upload an image', true)),array(
				'name' => 'data[User][avatar]',
				'value' => $this->data['User']['avatar']
			)); ?>
			<div>
				<? echo $form->file('avatar_file'); ?>
			</div>
		</p>
		
		<p>
			<? echo $form->radio('avatar',array('gravatar' => __('Gravatar', true)),array(
				'name' => 'data[User][avatar]',
				'value' => $this->data['User']['avatar']
			)); ?>
			<div>
				<label for="UserAvatarGravatar"><img src="http://www.gravatar.com/avatar.php?gravatar_id=<?= md5($this->data['User']['email']) ?>&size=96" /></label>
			</div>
		</p>
		
		<p>
			<? echo $form->radio('avatar',array('default' => __('Use default image', true)),array(
				'name' => 'data[User][avatar]',
				'value' => $this->data['User']['avatar']
			)); ?>
			<div>
				<label for="UserAvatarDefault"><img src="/img/icons/oxygen_refit/96x96/actions/stock_people.png" /></label>
			</div>
		</p>
	</fieldset>
	<?
	echo $form->input('first_name',array(
		'label' =>  __('First name', true),
		'between' => '<br/>',
		'autocomplete' => 'off'
	));
	echo $form->input('last_name',array(
		'label' =>  __('Last name', true),
		'between' => '<br/>'
	));
	echo $form->input('display_full_name',array(
		'label' =>  __('Display full name', true),
		'between' => ''
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

	echo $form->input('mailing_list',array(
		'label' =>  __('Add me to the InternetSeminary.org mailing list', true),
		'between' => ''
	));
	
	echo $form->end('Save');
	?>
</div>