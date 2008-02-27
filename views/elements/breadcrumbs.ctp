<div class="gclms-breadcrumbs">
	<?
	$trail = array();
	foreach($breadcrumbs as $title => $url) {
		//pr($url);
		$trail[] = $html->link(__($title,true),$url,array('target'=>'_top'));
	}
	$divider = __('TEXT DIRECTION',true) == 'rtl' ? ' < ' : ' > ';
	echo empty($breadcrumbs) ? 'Home': implode($divider,order($trail));
	?>
</div>