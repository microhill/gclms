<?
class DictionaryHelper extends AppHelper {	
	function linkify($text,$urlPrefix,$terms = array()) {
		foreach($terms as $term) {
			$pattern = '`\b(' . $term . ')\b`i';
			$anchor = '#' . Inflector::camelize($term);
			$replacement = "<a href='" . $urlPrefix . $anchor . "'>\\1</a>"; // target='sidebarContent'
			$text = preg_replace($pattern, $replacement, $text, 1);
		}
		return $text;
	}
}