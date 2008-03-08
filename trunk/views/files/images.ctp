<?= $this->renderElement('no_column_background'); ?>

<div class="gclms-content">	
	<div class="gclms-images">
	<?
	foreach($files as $file) { ?>
		<a href="<?= $file['uri'] ?>" onclick="return FileBrowserDialogue.chooseImage(this);" image:width="<?= $file['width'] ?>" image:height="<?= $file['height'] ?>" title="<?= $file['basename'] . ' (' . $file['width'] . 'x' . $file['height'] . ')' ?>">
			<div style="background-image: url('<?= $groupAndCoursePath . '/files/thumbnail/' . $file['basename'] ?>')"></div>
		</a>
	<? } ?>
	</div>
</div>