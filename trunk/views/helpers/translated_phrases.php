<?
class TranslatedPhrasesHelper extends AppHelper {	
	var $phrases = array();
	
	function add($phrase,$translation) {
		$this->phrases[$phrase] = $translation;
	}
	
	function getAll() {
		return $this->phrases;
	}
}