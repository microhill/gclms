<?
foreach($items as $item) {
	if(empty($item))
		continue;
			
	$link_options = array('escape' => false);

	$label = isset($item['label']) ? $item['label'] : Inflector::humanize(@$item['controller']);
	$class = isset($item['class']) ? $item['class'] : 'gclms-' . Inflector::humanize(@$item['controller']);

	if(!empty($item['active']))
		$class .= ' gclms-active';
	unset($item['active']);
	
	unset($item['label']);
	unset($item['class']);

	if(!isset($item['url'])) {
		$url = array();
		
		if(!is_string(@$item)) {
			if(isset($group))
				$url['group'] = Group::get('web_path');
				
			if(isset($course['web_path']) && !isset($item['courses']) && @$item['controller'] != 'courses')
				$url['courses'] = $course['web_path'];
	
			if(!isset($item['administration']))
				$url['administration'] = false;
	
			if(!isset($item['controller']))
				$url['controller'] = null;
			else
				$url['controller'] = low($item['controller']);
				
			$url['action'] = empty($item['action']) ? '' : $item['action'];
			//pr(am(@$item,$url));
			//pr(Router::url(am(@$item,$url)));
				
			$url = am(@$item,$url);
		}
	} else {
		$url = $item['url'];
	}
	
	echo '<li class="' . low($class) . '">';
	echo $html->link('' . __($label,true),$url,$link_options);
	echo '</li>';
}