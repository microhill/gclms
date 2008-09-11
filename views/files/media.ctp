<?
$html->css('files', null, null, false);

$javascript->link(array(
	'vendors/prototype1.6.0.2',
	'vendors/prototype_extensions1.0',
	'vendors/tinymce3.1.0.1/tiny_mce_popup',
	'tinymce_popup'
), false);

echo $this->element('no_column_background'); ?>
<div class="gclms-content gclms-files">
	<? if(empty($files)): ?>
		Empty.
	<? endif; ?>
	<ul>
	<?
	foreach($files as $file) {
		/*
		if(eregi('application/pdf',$file['type'])) {
			$type = 'pdf';
		} else if(eregi('video',$file['type'])) {
			$type = 'video';
		} else if(eregi('audio',$file['type'])) {
			$type = 'audio';
		} else if(eregi('application/msword',$file['type'])) {
			$type = 'word';
		} else if(eregi('image',$file['type'])) {
			$type = 'image';
		} else if(eregi('text',$file['type'])) {
			$type = 'document';
		} else {
			$type = 'mime';
		}
		*/

		echo "<li><a href='" . $file['uri'] . "'>" . $file['basename'] . "</a>" . '</li>';		
	}
	?>
	</ul>
</div>