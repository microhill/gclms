<?php
class FacilitatedClass extends AppModel {
    var $hasMany = array('ChatMessage','Notebook','ChatParticipant','Announcement');
    
    var $hasAndBelongsToMany = array(
		'Enrollee' =>
			array(
				'className'    => 'User',
				'joinTable'    => 'class_enrollees',
				'foreignKey'   => 'facilitated_class_id',
				'associationForeignKey'=> 'user_id',
				'unique'       => true
			),
		'Facilitator' =>
			array(
				'className'    => 'User',
				'joinTable'    => 'class_facilitators',
				'foreignKey'   => 'facilitated_class_id',
				'associationForeignKey'=> 'user_id',
				'unique'       => true
			)
	);
    
    var $belongsTo = array('Course');

	var $validate = array(
		'alias' => array(
			'rule' => VALID_NOT_EMPTY
		)
	);
}