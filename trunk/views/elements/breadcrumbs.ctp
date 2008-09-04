<div class="gclms-breadcrumbs">
	<?
	$trail = array();

	if(!empty($breadcrumbs)){
		foreach($breadcrumbs as $title => $options) {
			if(is_string($options)) {
				$url = $options;
			} else {
				$url = $options['url'];
				if(!empty($options['class'])) {
					$class = $options['class'];
				}
			}
			//pr($url);

			$attributes = array();
			if(!empty($class)) {
				$attributes['class'] = $class;
			}
			
			if($this->name == 'Classroom') {
				$attributes['target'] = '_top';
			}

			$trail[] = $html->link(__($title,true),$url,$attributes);
		}

		$divider = ' > ';
	
		echo empty($breadcrumbs) ? __('Home',true) : implode($divider,$trail);

	}
	?>
</div>