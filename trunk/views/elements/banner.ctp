<div class="banner">
	<a href="<?= empty($group['web_path']) ? '/' : '/' . $group['web_path'] ?>"><?
	
	if(!empty($group['web_path']) && !empty($group['logo'])) {
		$file = ROOT . DS . APP_DIR . DS . 'files' . DS . 'logos' . DS . $group['id'] . '.img';
		$imageInfo = getimagesize($file);
		switch($imageInfo['mime']) {
			case 'image/png':
				$extension = 'png';
			case 'image/jpeg':
				$extension = 'jpg';
			case 'image/gif':
				$extension = 'gif';
		}
		$lastModified = date('YmdHis', strtotime($group['logo_updated']));
		echo '<img src="/' . $group['web_path'] . '/files/logo/' . $lastModified . '.' . $extension . '" ' . $imageInfo[3] . ' />';
	} else {
		$file = ROOT . DS . APP_DIR . DS . 'webroot' . DS . 'img' . DS . 'temporary-logo-2007-11-16.png';
		$imageInfo = getimagesize($file);
		echo '<img src="/img/temporary-logo-2007-11-16.png" ' . $imageInfo[3] . ' />';
	}
	?></a>
</div>