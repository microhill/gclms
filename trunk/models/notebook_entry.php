<?php
class NotebookEntry extends AppModel {
	var $belongsTo = array('Course','User');
}