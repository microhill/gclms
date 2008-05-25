<?
$html->css('files', null, null, false);

$javascript->link(array(
	'vendors/prototype',
	'prototype_extensions',
	'gclms',
	'vendors/swfobject2.0/swfobject',
	'vendors/swfupload2.1.0/swfupload',
	'upload_files'
), false);

echo $this->element('left_column'); ?>

<div class="gclms-center-column">
	<div class="gclms-content">
		<?= $this->element('notifications'); ?>
		<h1><? __('Media Files') ?></h1>	
		<ul class="gclms-files">
		<?
		
		foreach($files as $file) {
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

			echo "<li class='" . $type . "'><a href='" . $file['uri'] . "'>" . $file['basename'] . "</a>" . '</li>';		
		}
		?>
		</ul>
		<div id="SWFUploadTarget" swfupload:uploadScript="/<?= $group['web_path'] ?>/<?= $course['web_path'] ?>/files/upload/file">
			<button id="browseButton" class="browseButton">
				<? __('Add File(s)') ?>
			</button>
			<button id="cancelQueueButton" class="cancelButton">
				<img src="/img/permanent/icons/2007-09-13/cancel-12.png"/> <? __('Cancel File Upload(s)') ?>
			</button>
		</div>

		<button id="gclms-upload-files" class="gclms-upload-files">
			<? __('Upload') ?>
		</button>

		<div id="SWFUploadFileListingFiles">
		</div>

		<br class="clr" />


		
		<div id="downloadProgress"></div>
	</div>
</div>

<?= $this->element('right_column'); ?>