<?= $this->element('left_column'); ?>
		
<div class="gclms-center-column">
	<div class="gclms-content">		
		<script type="text/javascript">
		    tinyMCE.init({
		        theme : "advanced",
		        width: "100%",
		        plugins : "media",
		        mode: "textareas",
				relative_urls : false,
		        editor_selector : "wysiwyg",
				theme_advanced_buttons1 : "bold,italic,underline,separator,strikethrough,justifyleft,justifycenter,justifyright,justifyfull,bullist,numlist",
				theme_advanced_buttons2 : "",
				theme_advanced_buttons3 : "",
				theme_advanced_toolbar_location : "top",
				theme_advanced_toolbar_align : "left",
				extended_valid_elements : "a[name|href|target|title|onclick],img[class|src|border=0|alt|title|hspace|vspace|width|height|align|onmouseover|onmouseout|name],hr[class|width|size|noshade],font[face|size|color|style],span[class|align|style]",
				content_css : "/css/tinymce.css"
		    });
		</script>
		
		<h1><?= __('Notebook') ?></h1>
		<?
		echo $form->create('NotebookEntry',array('id' => null,'url'=> '/' . $groupWebPath . '/' . $courseWebPath . 'notebook/add'));
		echo $form->input('content',array(
			'label' =>'',
			'rows' => 20,
			'cols' => 88,
			'class' => 'wysiwyg'
		));
		echo $form->submit(__('Save',true),array('class'=>'gclms-save'));
		echo $form->end();
		?>
	</div>
</div>

<?= $this->element('right_column'); ?>