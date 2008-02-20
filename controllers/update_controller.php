<?php

uses('model' . DS . 'schema');
uses('model' . DS . 'connection_manager');

class UpdateController extends AppController {
	var $uses = null;
    var $layout = 'install';
    
    function beforeRender() {}

    function beforeFilter() {
    	$this->MyAuth->allow('*');
    }

    function index() {
		Configure::write('debug', 1);
		
		$settings = am(array('path'=> CONFIGS .'sql'), $this->params);
		$this->Schema =& new CakeSchema($settings);
		
		$db =& ConnectionManager::getDataSource($this->Schema->connection);
		$db->fullDebug = true;
		$db->_sources = null;
		$db->cacheSources = false;
		$db->listSources();
		$currentTables = array_flip($db->sources());
		
		$models = Configure::listObjects('model');
		$schema = $this->Schema->load();		
		
		$tablesToCreate = array();
		foreach($models as $model) {
			$table = Inflector::tableize($model);
			if(!isset($currentTables[$table])) {
				$tablesToCreate[] = $table;
			}
		}
		
		foreach($tablesToCreate as $table) {
			$sql = str_replace("DEFAULT ''", '', $db->createSchema($schema,$table));
			pr($sql);
			$db->_execute($sql);
			$error = $db->lastError();
			if($error)
				echo $error;
			else
				echo __('Table insert successful.', true);
			
			echo '<br/>';
		}

		$currentTables = array_flip($db->sources());

		$old = $this->Schema->read();
		$compare = $this->Schema->compare($old, $schema);

		$table = null;
		if(isset($this->args[0])) {
			$table = $this->args[0];
			$compare = array($table => $compare[$table]);
		}

		$sql = $db->alterSchema($compare, $table);
		if(empty($sql)) {
			echo __('Database is up to date.', true);
			exit();
		}
		
		if(!$this->Schema->before($compare)) {
			return false;
		}

		$sql = str_replace("DEFAULT ''", '', $sql);
		pr($sql);
		if ($db->_execute($sql)) {
			$this->Schema->after($compare);
			echo  __('Database updated', true);
			exit();
		} else {
			echo __('Database could not be updated', true);
			echo $db->lastError();
			exit();
		}
		
		die();  	
    }
}