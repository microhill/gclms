<?
class DictionaryHelper extends AppHelper {	
	function linkify($text,$urlPrefix,$terms = array()) {
		foreach($terms as $term) {
			$pattern = '`\b(' . $term . ')\b`i';
			$anchor = '#' . Inflector::variable($term);
			$replacement = "<a target='sidebarContent' href='" . $urlPrefix . $anchor . "'>\\1</a>";
			$text = preg_replace($pattern, $replacement, $text, 1);
		}
		return $text;
	}
}