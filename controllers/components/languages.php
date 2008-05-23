<?
class LanguagesComponent extends Object {
	var $_languages = array(
		'en' => array(
			'englishName' => 'English',
			'internationalName' => 'English',
			'active' => true,
			'direction' => 'ltr'
		),
		'ar' => array(
			'englishName' => 'Arabic',
			'internationalName' => "العربية",
			'active' => true,
			'direction' => 'rtl'
		),
		'zh' => array(
			'englishName' => 'Chinese',
			'internationalName' => '&#31616;&#20307;&#20013;&#25991;',
			'active' => true,
			'direction' => 'ltr'
		),
		/*
		'ko' => array(
			'englishName' => 'Korean',
			'internationalName' => '&#54620;&#44397;&#50612;',
			'active' => true,
			'direction' => 'ltr'
		),
		'vi' => array(
			'englishName' => 'Vietnamese',
			'internationalName' => 'Vi&#7879;t Ng&#432;&#771;',
			'active' => true,
			'direction' => 'ltr'
		),
		'ru' => array(
			'englishName' => 'Russian',
			'internationalName' => 'Py&#1089;&#1089;&#1082;&#1080;&#1081;',
			'active' => true,
			'direction' => 'ltr'
		),
		'sw' => array(
			'englishName' => 'Swahili',
			'internationalName' => 'Kiswahili',
			'active' => true,
			'direction' => 'ltr'
		),
		'es' => array(
			'englishName' => 'Spanish',
			'internationalName' => 'Espa&#241;ol',
			'active' => true,
			'direction' => 'ltr'
		),
		'de' => array(
			'englishName' => 'German',
			'internationalName' => 'Deutsch',
			'active' => true,
			'direction' => 'ltr'
		),
		'th' => array(
			'englishName' => 'Thai',
			'internationalName' => '&#3616;&#3634;&#3625;&#3634;&#3652;&#3607;&#3618;',
			'active' => true,
			'direction' => 'ltr'
		),
		'fr' => array(
			'englishName' => 'French',
			'internationalName' => 'Français',
			'active' => true,
			'direction' => 'ltr'
		),
		'pt' => array(
			'englishName' => 'Portuguese',
			'internationalName' => "Português",
			'active' => true,
			'direction' => 'ltr'
		)
		*/
		
		/*,
		'ja' => array(
			'englishName' => 'Japanese',
			'internationalName' => 'æ—¥æœ¬èªž',
			'active' => false
		),
		'ms' => array(
			'englishName' => 'Malay',
			'internationalName' => 'Malay',
			'active' => false
		)*/
	);
	
	function generateList() {
		$list = array();
		foreach($this->_languages as $code => $language) {
			$list[$code] = $language['internationalName'];
		}
		return $list;
	}
	
	function getDirection($language_code) {
		return $this->_languages[$language_code]['direction'];
	}
}