<?
$javascript->link(array(
	'vendors/prototype1.6.0.3',
	'vendors/prototype_extensions1.0',
	'vendors/tinymce3.1.0.1/tiny_mce_popup',
	'tinymce_popup'
), false);

?>

<div class="gclms-content">	
	<div class="gclms-images">
	<? if(empty($images)): ?>
		Empty.
	<? endif; ?>
	<?
	foreach($images as $image) { ?>
		<a href="<?= $image['uri'] ?>" image:width="<?= @$image['width'] ?>" image:height="<?= @$image['height'] ?>">
			<div style="background-image: url('<?= $groupAndCoursePath . '/files/thumbnail/' . $image['basename'] ?>')"></div> <?= $image['basename'] ?> (<?= $image['width'] ?> x <?= $image['height'] ?>; <?= $image['size'] ?>)
		</a>
	<? } ?>
	</div>
</div>