<?php
class Grade extends AppModel {
    var $belongsTo = array('User','Node');
}