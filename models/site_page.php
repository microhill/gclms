<?
class SitePage extends AppModel {
	var $validate = array(
		'title' => array(
			'rule' => VALID_NOT_EMPTY
		),
		'content' => array(
			'rule' => VALID_NOT_EMPTY
		)
	);
}