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

<?
echo $form->input('title',array(
	'label' =>'Title',
	'between' => '<br/>',
	'id' => 'gclms-new-entry-title'
));
echo $form->input('content',array(
	'label' =>'',
	'rows' => 20,
	'cols' => 88,
	'id' => 'gclms-new-entry-content',
	'label' => false
));
?>
<p><? __('Should this entry be kept private?'); ?></p>
<div>
<?
echo $form->radio('private',
	array(1 => 'Yes', 0 => 'No'),
	array(
		'legend' =>  false,
		'separator' => '<br />',
		'value' => isset($this->data['NotebookEntry']['private']) ? $this->data['NotebookEntry']['private'] : 1
	)
);
?>
</div>