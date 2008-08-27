<?
$javascript->link(array(
	'vendors/prototype',
	'prototype_extensions',
	'gclms',
	'notebook'
), false);

echo $this->element('left_column'); ?>
		
<div class="gclms-center-column">
	<div class="gclms-content">		
		<!--script type="text/javascript">
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
		</script-->
		
		<h1><?= __('Notebook') ?></h1>
		<h2><? __('Add Entry') ?></h2>
		<div class="gclms-new-notebook-entry">
			<?
			echo $form->input('title',array(
				'label' =>'Title (optional)',
				'between' => '<br/>',
				'id' => 'gclms-new-entry-title'
			));
			echo $form->input('content',array(
				'label' =>'',
				'rows' => 20,
				'cols' => 88,
				'id' => 'gclms-new-entry-content'
			));
			echo $this->element('buttons',array('buttons' => array(
				array(
					'text' => __('Save',true),
					'hover_color' => 'green',
					'class' => 'gclms-submit'
				)
			)));
			?>
		</div>
		<? foreach($this->data as $entry): ?>
			<div class="gclms-notebook-entry">
				<h2><?= $myTime->niceShortDate($entry['NotebookEntry']['created']) ?></h2>
				<?= $entry['NotebookEntry']['content'] ?>
			</div>
		<? endforeach; ?>
	</div>
</div>

<?= $this->element('right_column'); ?>