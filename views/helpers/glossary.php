<?
class GlossaryHelper extends AppHelper {	
	function linkify($text,$urlPrefix,$terms = array()) {
		foreach($terms as $term) {
			$pattern = '`\b(' . $term['GlossaryTerm']['term'] . ')\b`i';
			$replacement = "<a href='" . $urlPrefix . $term['GlossaryTerm']['id'] . "'>\\1</a>"; // target='sidebarContent'
			$text = preg_replace($pattern, $replacement, $text, 1);
		}
		return $text;
	}
}