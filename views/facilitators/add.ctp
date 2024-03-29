<div class="gclms-content">
	<div id="gclms-spinner"><img src="/img/spinner.gif" alt="Spinner" /></div>
	<h1><?= __('Add Facilitator') ?></h1>    
		<?
		echo $form->create('GroupFacilitator', array('id' => null, 'url' => '/' . Group::get('web_path') . '/facilitators/add'));
		echo $form->hidden('group_id',array(
			'value' => $this->viewVars['group']['id']
		));
		echo $form->hidden('approved',array(
			'value' => 1
		));
		echo $form->input('username',array(
			'label' =>  __('Username', true),
			'between' => '<br/>',
			'autocomplete' => 'off'
		));
		echo $form->submit(__('Save',true),array(
			'class' => 'Save',
			'error:message' => __('You must first select a valid username.',true)
		));
		echo $form->end();
		?>
	</div>
</div>