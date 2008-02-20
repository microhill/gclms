<?= $this->renderElement('no_column_background'); ?>
<div class="gclms-content">	
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

		echo "<li class='" . $type . "'><a href='" . $file['uri'] . "' onclick='return chooseFile(this);'>" . $file['basename'] . "</a>" . '</li>';		
	}
	?>
	</ul>
</div>