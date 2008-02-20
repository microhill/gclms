<?php
class Notebook extends AppModel {
	var $belongsTo = array('Course','User');
}