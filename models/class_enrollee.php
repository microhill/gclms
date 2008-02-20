<?php
class ClassEnrollee extends AppModel {
	var $belongsTo = array('FacilitatedClass','User');
}