<?
class GroupSetting extends AppModel {
    var $belongsTo = array('Group');
	
	var $validate = array(
		'group_id' => array(
			'rule' => VALID_NOT_EMPTY
		),
		'setting' => array(
			'rule' => VALID_NOT_EMPTY
		),
		'value' => array(
			'rule' => VALID_NOT_EMPTY
		)
	);
}