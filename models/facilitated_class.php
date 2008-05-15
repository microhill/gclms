<?
class FacilitatedClass extends AppModel {    
    var $hasAndBelongsToMany = array(
		'Facilitator' =>
			array(
				'className'    => 'User',
				'joinTable'    => 'class_facilitators',
				'foreignKey'   => 'virtual_class_id',
				'associationForeignKey'=> 'user_id',
				'unique'       => true
			)
	);
    
    var $belongsTo = array('VirtualClass');
}