<?
class PluginsController extends AppController {
    var $uses = array('Plugin');
	var $helpers = array('Paginator','MyPaginator');
	
	function administration_index() {
		Configure::load('plugins');
		$activatedPlugins = Configure::read('Plugins.activated');
		$plugins = array();
		$pluginsDirectory = ROOT . DS . APP_DIR . DS . 'plugins';
		if($handle = opendir($pluginsDirectory)) {
		    while (false !== ($file = readdir($handle))) {
		        if($file == '..' || $file == '.' || $file == '.svn' || !is_dir($pluginsDirectory . DS . $file))
					continue;
				include($pluginsDirectory . DS . $file . DS . 'config.php');
				$plugin['folder'] = $file;
				if(!empty($activatedPlugins[$file]))
					$plugin['activated'] = true;
				$plugins[] = array('Plugin' => $plugin);
		    }
		    closedir($handle);
		}
		$this->data = $plugins;
	}
	
	function administration_toggle($folder) {
		$configDirectory = ROOT . DS . APP_DIR . DS . 'config';
		$pluginsDirectory = ROOT . DS . APP_DIR . DS . 'plugins';
		Configure::load('plugins');
		$activatedPlugins = Configure::read('Plugins.activated');
		if(empty($activatedPlugins)) {
			$activatedPlugins = array($folder => true);
		} else {
			if(!empty($activatedPlugins[$folder]))
				unset($activatedPlugins[$folder]);
			else
				$activatedPlugins[$folder] = true;
		}

		/*
		if(!empty($activatedPlugins[$folder])) {
			$db = ConnectionManager::getDataSource('default');
			if(!is_file($pluginsDirectory . DS . $folder . DS . 'installed.txt') && is_file($pluginsDirectory . DS . $folder . DS . $folder . '.sql')) {
				$this->__executeSQLScript($db, $pluginsDirectory . DS . $folder . DS . $folder . '.sql');
				file_put_contents($pluginsDirectory . DS . $folder . DS . 'installed.txt','.1');
			}
		}
		*/
		
		foreach($activatedPlugins as $pluginFolder => $value) {
			if(empty($pluginFolder))
				continue;
			if(!file_exists($pluginsDirectory . DS . $pluginFolder . DS . 'config.php'))
				die('ahh!');
			include($pluginsDirectory . DS . $pluginFolder . DS . 'config.php');
			$type = $plugin['type'];
			$content .= "'$pluginFolder' => '$type',";
		}
		$content = "<?\n\$config['Plugins']['activated'] = array(\n\t$content\n);";
		file_put_contents($configDirectory . DS . 'plugins.php',$content);
		$this->redirect('/administration/plugins');
	}
	
    function __executeSQLScript($db, $fileName) {
		//$statements = file_get_contents($fileName);
		//echo strlen($statements);
		//$db->rawQuery($statements);
        //die('test');

		/*
        $statements = explode(';', $statements);
        
		foreach ($statements as $statement) {
            if (trim($statement) != '') {
                $db->query($statement);
            }
        }
        */
		
		$fp = fopen($fileName, 'r');
		while( !feof($fp) )
		{
		    $statement = getline($fp, ';');
		    $db->query($statement);
		}
		fclose($fp);
		
		return true;
    }
}

function getline( $fp, $delim ) {
    $result = "";
    while( !feof( $fp ) )
    {
        $tmp = fgetc( $fp );
        if( $tmp == $delim )
            return $result;
        $result .= $tmp;
    }
    return $result;
}