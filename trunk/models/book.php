<?php
class Book extends AppModel {
    var $belongsTo = array('Course');
    var $hasMany = array('Chapter');
}