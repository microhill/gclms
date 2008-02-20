<?php
class Textbook extends AppModel {
    var $belongsTo = array('Course');
    var $hasMany = array('Chapter');
}