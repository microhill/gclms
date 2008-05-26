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
				<?
				echo $this->element('menubar',array('buttons' => array(
					array(
						'id' => 'gclms-upload-files',
						'class' => 'gclms-add',
						'label' => __('Add Files',true)
					),
					array(
						'id' => 'gclms-delete',
						'class' => 'gclms-delete',
						'label' => __('Delete',true)
					),
					array(
						'id' => 'gclms-rename',
						'class' => 'gclms-rename',
						'label' => __('Rename',true)
					)
				)));
				?>
		<? if(!empty($files)): ?>
			<table class="gclms-tabular" cellspacing="0" id="gclms-files">
				<tr>
					<th style="width: 1px;">
						<input type="checkbox" id="gclms-select-all" />
					</th>
					<th>
						<? __('Name') ?>
					</th>
					<th style="width: 1px;">
						<? __('Size') ?>
					</th>
				</tr>
			<?
			
			foreach($files as $file):
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
	
				//echo "<li class='" . $type . "'><a href='" . $file['uri'] . "'>" . $file['basename'] . "</a>" . '</li>';		
				?>
				<tr>
					<td>
						<input type="checkbox" class="gclms-file-select" name="data[files][]" value="<?= $file['basename'] ?>" />
					</td>
					<td>
						<a href="<?= $file['uri'] ?>"><?= $file['basename'] ?></a>			
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

		<div id="SWFUploadFileListingFiles">
		</div>

		<br class="clr" />

		<div id="downloadProgress"></div>
	</div>
</div>

<?= $this->element('right_column'); ?>