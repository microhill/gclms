<?
$html->css('ltr', null, null, false);
$html->css('main', null, null, false);

echo $this->renderElement('no_column_background'); ?>
<style>
div.files a {
	display: block;
	width: 100px;
	height: 100px;
	padding: 5px;
	float: left;
	text-align: center;
	border: 1px solid #eaeaea;
	background-color: white;
	margin-right: 5px;
}

	div.files a div {
		width: 100px;
		height: 100px;
		background-repeat: no-repeat;
		background-position: center center;
	}

div.files a:hover {
	border: 1px solid #adadad;
}
	
</style>

<div class="gclms-content">	
	<div class="files">
	<?
	foreach($files as $file) { ?>
		<a href="<?= $file['uri'] ?>" onclick="return FileBrowserDialogue.chooseFile(this);" image:width="<?= $file['width'] ?>" image:height="<?= $file['height'] ?>" title="<?= $file['basename'] . ' (' . $file['width'] . 'x' . $file['height'] . ')' ?>">
			<div style="background-image: url('<?= $groupAndCoursePath . '/files/thumbnail/' . $file['basename'] ?>')"></div>
		</a>
	<? } ?>
	</div>
</div>