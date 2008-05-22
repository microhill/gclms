<div class="gclms-breadcrumbs">
	<?
	$trail = array();
	if(!empty($breadcrumbs)){
		foreach($breadcrumbs as $title => $url) {
			//pr($url);
			$trail[] = $html->link(__($title,true),$url,array('target'=>'_top'));
		}

		$divider = ' > ';
	
		echo empty($breadcrumbs) ? 'Home': implode($divider,$trail);
	}
	?>
</div>