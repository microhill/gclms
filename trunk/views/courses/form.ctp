<?
echo $form->input('title',array(
	'label' =>  __('Title', true),
	'between' => '<br/>'
));
echo $form->input('web_path',array(
	'label' =>  __('Web path',true) . ' <img class="gclms-tooltip-button" src="/img/icons/oxygen/16x16/actions/dialog-information.png" tooltip:text="'.__('This is part of what makes up the web address of your course. It can be made up of lower case letters, numbers, or hypens. The end result will be something like', true).': <br/><br/><strong>' . Configure::read('App.domain') . $group['web_path'] . '/web-path</strong>" /> ',
	'between' => '<br/>',
	'error' => array(
		'duplicateWebPath' => __('A course already exists in your group with this web path.',true)
	)
));
//echo urlencode($this->data['Course']['web_path']);
echo $form->input('language',array(
	'label' =>  __('Language', true),
	'between' => '<br/>',
	'escape' => false
));

echo $form->radio('published_status',
	array(0 => __('Draft', true),1 => __('Published', true)),
	array(
		'legend' =>  __('Status', true),
		'separator' => '<br />'
	)
);

echo $form->radio('open',
	array(0 => __('No', true),1 => __('Yes', true)),
	array(
		'legend' =>  __('Allow non-enrollees to view course content?', true),
		'separator' => '<br />'
	)
);

echo $form->radio('redistribution_allowed',
	array(0 => __('No', true),1 => __('Yes', true)),
	array(
		'legend' =>  __('Allow others to freely redistribute this course?', true) . ' <img class="gclms-tooltip-button" src="/img/icons/oxygen/16x16/actions/dialog-information.png" tooltip:text="'.__('If you allow your course to be freely redistributable, it will be under a Creative Commons license. This requires attribution to the author(s) of the course but provides freedoms that will make it easier for others to disseminate the content. You can learn more about Creative Commons licenses at', true).':<br/><br/><strong>CreativeCommons.org/license</strong>" /> ',
		'class' => 'allowRedistribution',
		'separator' => '<br />'
	)
);
?>
<div id="extendedLicensingOptions" class="<?= empty($this->data['Course']['redistribution_allowed']) ? 'gclms-hidden' : '' ?>">
	<?
	echo $form->radio('derivative_works_allowed',
		array(0 => __('No', true),1 => __('Yes', true),2 => __('Yes, as long as they share alike', true)),
		array(
			'legend' =>  __('Allow others to adapt and modify redistributions of this course?', true),
			'separator' => '<br />'
		)
	);

	echo $form->radio('commercial_use_allowed',
		array(0 => __('No', true),1 => __('Yes', true)),
		array(
			'legend' =>  __('Allow others to make commercial use of redistributions of this course?', true),
			'separator' => '<br />'
			
		)
	);
	?>
</div>
<?
echo $form->input('description',array(
	'label' => __('Description',true),
	'between' => '<br/>',
	'rows' => 25,
	'cols' => 100
));
echo $form->input('css',array(
	'rows' => 12,
	'cols' => 100,
	'label' => __('Custom CSS',true),
	'between' => '<br/>'
));
?>