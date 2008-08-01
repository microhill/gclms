<?
$javascript->link(array(
	'vendors/prototype',
	'prototype_extensions',
	'vendors/tinymce3.1.0.1/tiny_mce_popup',
	'tinymce_popup'
), false);

echo $this->element('no_column_background'); ?>

<div class="gclms-content">	
	<div class="gclms-images">
	<? if(empty($images)): ?>
		Empty.
	<? endif; ?>
	<?
	foreach($images as $image) { ?>
		<a href="<?= $image['uri'] ?>" image:width="<?= @$image['width'] ?>" image:height="<?= @$image['height'] ?>">
			<div style="background-image: url('<?= $groupAndCoursePath . '/files/thumbnail/' . $image['basename'] ?>')"></div> <?= $image['basename'] ?>
		</a>
	<? } ?>
	</div>
</div>