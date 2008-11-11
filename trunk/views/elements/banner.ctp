<div class="gclms-banner">
	<a href="<?= class_exists('Group') && Group::get('web_path') ? '/' . Group::get('web_path') : '/' ?>"><?
	
	if(class_exists('Group') && Group::get('web_path') && Group::get('logo')) {
		$file = ROOT . DS . APP_DIR . DS . 'files' . DS . 'logos' . DS . Group::get('id') . '.img';
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
		echo '<img src="/' . Group::get('web_path') . '/files/logo/' . $lastModified . '.' . $extension . '" ' . $imageInfo[3] . ' alt="' . __('Logo for ',true) . $group['name'] . '" />';
	} else {
		$file = ROOT . DS . APP_DIR . DS . 'webroot' . DS . 'img' . DS . 'logos' . DS . Configure::read('Config.language') . '.png';
		if(file_exists($file)) {
			$imageInfo = getimagesize($file);
			
			if(empty($here))
				$here = $this->here;
			if(empty($here))
				$here = '/';
				
			$img = relativize_url($here,'/img/logos/' . Configure::read('Config.language') . '.png');
			echo '<img src="' . $img . '" ' . $imageInfo[3] . ' alt="' . __('Logo for GCLMS',true) .  '" />';			
		}
	}
	?></a>
</div>