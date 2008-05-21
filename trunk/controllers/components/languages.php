<?
class LanguagesComponent extends Object {
	var $_languages = array(
		array(
			'code' => 'en',
			'englishName' => 'English',
			'internationalName' => 'English',
			'active' => true
		),
		array(
			'code' => 'ar',
			'englishName' => 'Arabic',
			'internationalName' => "العربية",
			'active' => true
		),
		array(
			'code' => 'ko',
			'englishName' => 'Korean',
			'internationalName' => '&#54620;&#44397;&#50612;',
			'active' => true
		),
		array(
			'code' => 'zh',
			'englishName' => 'Chinese',
			'internationalName' => '&#31616;&#20307;&#20013;&#25991;',
			'active' => true
		),
		array(
			'code' => 'vi',
			'englishName' => 'Vietnamese',
			'internationalName' => 'Vi&#7879;t Ng&#432;&#771;',
			'active' => true
		),
		array(
			'code' => 'ru',
			'englishName' => 'Russian',
			'internationalName' => 'Py&#1089;&#1089;&#1082;&#1080;&#1081;',
			'active' => true
		),
		array(
			'code' => 'sw',
			'englishName' => 'Swahili',
			'internationalName' => 'Kiswahili',
			'active' => true
		),
		array(
			'code' => 'es',
			'englishName' => 'Spanish',
			'internationalName' => 'Espa&#241;ol',
			'active' => true
		),
		array(
			'code' => 'de',
			'englishName' => 'German',
			'internationalName' => 'Deutsch',
			'active' => true
		),
		array(
			'code' => 'th',
			'englishName' => 'Thai',
			'internationalName' => '&#3616;&#3634;&#3625;&#3634;&#3652;&#3607;&#3618;',
			'active' => true
		),
		array(
			'code' => 'fr',
			'englishName' => 'French',
			'internationalName' => 'Français',
			'active' => true
		),
		array(
			'code' => 'pt',
			'englishName' => 'Portuguese',
			'internationalName' => "Português",
			'active' => true
		)/*,
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
		return array_combine(Set::extract($this->_languages, '{n}.code'), Set::extract($this->_languages, '{n}.internationalName'));
	}
}