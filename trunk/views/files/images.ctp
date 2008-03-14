<?
$javascript->link(array(
	'vendors/prototype',
	'prototype_extensions',
	'vendors/tinymce3.0.5/tiny_mce_popup',
	'tinymce_popup'
), false);

echo $this->renderElement('no_column_background'); ?>

<div class="gclms-content">	
	<div class="gclms-images">
	<? if(empty($files)): ?>
		Empty.
	<? endif; ?>
	<?
	foreach($files as $file) { ?>
		<a href="<?= $file['uri'] ?>" image:width="<?= $file['width'] ?>" image:height="<?= $file['height'] ?>" title="<?= $file['basename'] . ' (' . $file['width'] . 'x' . $file['height'] . ')' ?>">
			<div style="background-image: url('<?= $groupAndCoursePath . '/files/thumbnail/' . $file['basename'] ?>')"></div>
		</a>
	<? } ?>
	</div>
</div>