<?
$html->css('files', null, null, false);

$javascript->link(array(
	'vendors/prototype1.6.0.3',
	'vendors/prototype_extensions1.0',
	'gclms',
	'vendors/swfupload2.2.0/swfupload',
	//'http://demo.swfupload.org/v220beta4/simpledemo/js/swfupload.queue.js',
	//'http://demo.swfupload.org/v220beta4/simpledemo/js/handlers.js',
	'upload_files',
	'mime_types',
	'popup'
), false);

echo $this->element('left_column'); ?>

<div class="gclms-center-column">
	<div class="gclms-content">
		<?= $this->element('notifications'); ?>
		<h1><? __('Media Files') ?></h1>
		<form action="<?= $groupAndCoursePath ?>/files/" method="post">
			<table class="gclms-buttons">
				<tr>
					<td>
						<button class="gclms-delete-files">Delete</button>
					</td>
					<!--td>
						<button class="gclms-rename">Rename</button>
					</td-->
				</tr>
			</table>

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
					<tbody>
					<?
					if(!empty($files)) {
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
									<input type="checkbox" class="gclms-file-select" name="data[Files][]" value="<?= basename($file['name']) ?>" />
								</td>
								<td>
									<a href="<?= $file['uri'] ?>"><?= basename($file['name']) ?></a>			
								</td>
								<td style="white-space: nowrap;">
									<?= $file['size'] ?>
								</td>
							</tr>
						<? endforeach;						
					}
					?>

					</tbody>
				</table>
		</form>	
		
		<?
		$form_action = 'https://' . Configure::read('S3.bucket') . '.s3.amazonaws.com/';

		$acl = empty($course['open']) ? 'private' : 'public-read';

		$policy = array(
			'expiration' => date('Y-m-d',strtotime('+2 days')) . 'T00:00:00Z',
			'conditions' => array(
				array('bucket' => Configure::read('S3.bucket')),
				//array('success_action_redirect' => Configure::read('App.domain') . $this->here),
				array('starts-with','$key','courses/' . $course['id'] . '/'),
				array('starts-with','$Filename',''),
				array('starts-with','$Content-Type',''),
				array('content-length-range',3,31457280),
				array('acl'=>$acl),
				array('success_action_status'=>'201')
			)
		);
		
		$policy = base64_encode($javascript->object($policy));
		
		$signature = base64_encode(hash_hmac('sha1', $policy, Configure::read('S3.secretKey'), TRUE));
		?>
		
		<div id="downloadProgress"></div>

		<form id="form1" action="<?= $form_action ?>" method="post" enctype="multipart/form-data">	
			<input type="hidden" id="s3key" name="key" value="courses/<?= $course['id'] ?>/${filename}"/>
			<input type="hidden" id="s3awsaccesskeyid" name="AWSAccessKeyId" value="<?= Configure::read('S3.accessKey') ?>"/> 
			<input type="hidden" id="s3acl" name="acl" value="<?= $acl ?>"/>
			<input type="hidden" id="s3policy" name="policy" value="<?= $policy ?>"/>
			<input type="hidden" id="s3signature" name="signature" value="<?= $signature ?>"/>
			<input type="hidden" id="s3contenttype" name="Content-Type" value="application/octet-stream"/>
			<input type="hidden" id="s3successactionredirect" name="success_action_redirect" value="<?= Configure::read('App.domain') . $this->here ?>"/>
			<input type="hidden" id="s3successactionstatus" name="success_action_status" value="201"/>
			<div>
				<span id="spanButtonPlaceHolder"></span>
				<!-- input id="btnCancel" type="button" value="Cancel All Uploads" onclick="swfu.cancelQueue();" disabled="disabled" style="margin-left: 2px; font-size: 8pt; height: 29px;" / -->
			</div>
		</form>
		<div id="divServerData"></div>
	</div>
</div>

<?= $this->element('right_column'); ?>