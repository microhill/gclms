<?
$html->css('files', null, null, false);

$javascript->link(array(
	'vendors/prototype',
	'prototype_extensions',
	'gclms',
	'vendors/swfupload/SWFUpload',
	'upload_files'
), false);

echo $this->renderElement('left_column'); ?>

	<style type="text/css">
		
		.swfuploadbtn {
			display: block;
			width: 100px;
			padding: 0 0 0 20px;
		}
		
		.browsebtn { background: url(/images/add.png) no-repeat 0 4px; }
		.uploadbtn { 
			display: none;
			background: url(/images/accept.png) no-repeat 0 4px; 
		}
		
		.cancelbtn { 
			display: block;
			width: 16px;
			height: 16px;
			float: right;
			background: url(/img/permanent/icons/2007-09-13/cancel-16.png) no-repeat; 
		}
		
		#SWFUploadFileListingFiles ul {
			margin: 0;
			padding: 0;
			list-style: none;
		}

		.SWFUploadFileItem {
			margin-bottom: 4px;
		}

		.fileUploading {
			/* background: #fee727; */
		}
		.uploadCompleted { background: #d2fa7c; }
		.uploadCancelled { background: #f77c7c; }
		
		.uploadCompleted .cancelbtn, .uploadCancelled .cancelbtn {
			display: none;
		}
		
		span.progressBar {
			display: block;
			padding: 4px;
			background-color: #00B521;
			background-image: url(/img/progress-background.gif);
			background-repeat: no-repeat;
			background-position: 0 0;
		}
		
	</style>

<div class="gclms-center-column">
	<div class="gclms-content">
		<?
		// $this->renderElement('notifications');
		?>
		<h1><? __('Media Files') ?></h1>	
		<ul class="files">
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
			<div id="loadingSWFTarget">Loading...</div>
			<button id="browseButton" class="browseButton">
				<img src="/img/permanent/icons/2007-09-13/add-12.png"/> <? __('Add File(s)') ?>
			</button>
			<button id="cancelQueueButton" class="cancelButton">
				<img src="/img/permanent/icons/2007-09-13/cancel-12.png"/> <? __('Cancel File Upload(s)') ?>
			</button>
		</div>

		<div id="SWFUploadFileListingFiles">
		</div>

		<br class="clr" />


		
		<div id="downloadProgress"></div>
	</div>
</div>

<?= $this->renderElement('right_column'); ?>