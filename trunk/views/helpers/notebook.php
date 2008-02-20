<?
class NotebookHelper extends AppHelper {	
	function linkify($text,$urlPrefix) {
		$pattern = '/\[notebook\]/';
		if(empty($urlPrefix))
			$replacement = '';
		else
			$replacement = '<a href="' . $urlPrefix . '/location:sidebar" class="notebookLink" target="sidebarContent"><img src="/img/permanent/icons/2007-09-13/notebook-32.png" /></a>';
		return preg_replace($pattern, $replacement, $text);
	}
}