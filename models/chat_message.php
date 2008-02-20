<?php
class ChatMessage extends AppModel {
	var $belongsTo = array('FacilitatedClass','User');
}