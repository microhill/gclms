<?php
class ChatParticipant extends AppModel {
    var $belongsTo = array('FacilitatedClass','User');
}