<?
$html->css('files', null, null, false);

$javascript->link(array(
	'vendors/prototype1.6.0.2',
	'vendors/prototype_extensions1.0',
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
		<table class="gclms-buttons">
			<tr>
				<td>
					<button class="gclms-delete-files">Delete</button>
				</td>
				<td>
					<button class="gclms-rename">Rename</button>
				</td>
			</tr>
		</table>
		<? if(!empty($files)): ?>
			<table class="gclms-tabular" cellspacing="0" id="gclms-files">
				<tr>
					<th style="width: 1px;">
						<input type="checkbox" id="gclms-select-all" />
					</th>
					<th>
						<? __('Name') ?>
					</th>
					<th style="width: 1px;white-space:nowrap;">
						<? __('Size') ?> (<?= @$total_size ?>)
					</th>
				</tr>
			<?
			
			foreach($files as $file):
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
	
				//echo "<li class='" . $type . "'><a href='" . $file['uri'] . "'>" . $file['basename'] . "</a>" . '</li>';		
				?>
				<tr class="gclms-file">
					<td>
						<input type="checkbox" class="gclms-file-select" name="data[files][]" value="<?= basename($file['name']) ?>" />
					</td>
					<td>
						<a href="<?= $file['uri'] ?>"><?= basename($file['name']) ?></a>			
					</td>
					<td style="white-space: nowrap;">
						<?= $file['size'] ?>
					</td>
				</tr>
			<? endforeach; ?>
			</table>
		<? endif; ?>
		<div id="SWFUploadTarget" swfupload:uploadScript="/<?= $group['web_path'] ?>/<?= $course['web_path'] ?>/files/upload/file">
			<button id="gclms-cancel-queue-button" class="cancelButton">
				<img src="/img/permanent/icons/2007-09-13/cancel-12.png"/> <? __('Cancel File Upload(s)') ?>
			</button>
		</div>

		<!--div id="SWFUploadFileListingFiles"></div -->

		<br class="clr" />

		<div id="downloadProgress"></div>
		
		<?
		$form_action = 'https://' . Configure::read('S3.bucket') . '.s3.amazonaws.com/';

		$acl = empty($course['open']) ? 'private' : 'public-read';

		$policy = array(
			'expiration' => '2009-01-01T00:00:00Z',
			'conditions' => array(
				array('bucket' => Configure::read('S3.bucket')),
				array('success_action_redirect' => Configure::read('App.domain') . $this->here),
				array('starts-with','$key','courses/' . $course['id'] . '/'),
				array('starts-with','$Content-Type',''),
				array('content-length-range',10,31457280),
				array('acl'=>$acl)
			)
		);
		
		$policy = base64_encode($javascript->object($policy));
		
		$signature = base64_encode(hash_hmac('sha1', $policy, Configure::read('S3.secretKey'), TRUE));
		?>
		
		<form action2="http://test/upload" action="<?= $form_action ?>" method="post" enctype="multipart/form-data">
			<input type="hidden" name="key" value="courses/<?= $course['id'] ?>/${filename}"/>
			<input type="hidden" name="AWSAccessKeyId" value="<?= Configure::read('S3.accessKey') ?>"/> 
			<input type="hidden" name="acl" value="<?= $acl ?>"/>
			<input type="hidden" name="policy" value="<?= $policy ?>"/>
			<input type="hidden" name="signature" value="<?= $signature ?>"/>
			<input type="hidden" name="Content-Type" value="application/octet-stream"/>
			<!-- input type="hidden" name="acl" value="public" -->
			<input type="hidden" name="success_action_redirect" value="<?= Configure::read('App.domain') . $this->here ?>"/>
			<!-- input type="hidden" name="Content-Type" value="image/jpeg" -->
			
			
			<? __('Choose file to upload:') ?>
			<input name="file" type="file"> <input type="submit" value="Upload File"> 
		</form>
	</div>
</div>

<?= $this->element('right_column'); ?>