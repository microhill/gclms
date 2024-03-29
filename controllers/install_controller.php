<?
uses('model' . DS . 'connection_manager');

class InstallController extends AppController {
	var $uses = array();
	var $components = array('Breadcrumbs','Languages');
    var $layout = 'default';
    
    function beforeRender() {
		$this->Breadcrumbs->addCrumb(__('Great Commission Learning Management System',true),'/');
		$this->Breadcrumbs->addCrumb(__('Installer',true),'');
		parent::beforeRender();
	}

    function beforeFilter() {
		$this->css_for_layout[] = 'install';
		
		parent::beforeFilter();
        if(file_exists(CONFIGS.'installed.txt') && $this->action != 'update') {
            echo 'Application already installed. Remove app/config/installed.txt to reinstall the application';
            exit;
        }
		
		if($this->action != 'database' && !file_exists(CONFIGS.'database.php')) {
			$this->redirect('/install/database', null, true);
		}

		if(!in_array($this->action,array('database','configuration','tables')) && !file_exists(CONFIGS.'options.php')) {
			$this->redirect('/install/configuration', null, true);
		}
		
		$this->set('title', __('Great Commission Learning Management System',true));
    }

    function index() {
		$this->redirect('/install/database', null, true);    	
    }
    
    function database() {
		if(!empty($this->data['Database']['host']) && !empty($this->data['Database']['username']) && !empty($this->data['Database']['database'])) {     	
			$content = "<?\nclass DATABASE_CONFIG{\n	var \$default = array("
				. "\n		'driver' => 'mysql',"
				. "\n		'connect' => 'mysql_connect',"
				. "\n		'host' => '" . $this->data['Database']['host'] . "',"
				. "\n		'login' => '" . $this->data['Database']['username'] . "',"
				. "\n		'password' => '" . @$this->data['Database']['password'] . "',"
				. "\n		'database' => '" . $this->data['Database']['database'] . "',"
				. "\n		'prefix' => '');\n}";

			file_put_contents(CONFIGS.'database.php', $content);
		}

		if(file_exists(CONFIGS.'database.php')) {
			$this->redirect('/install/tables');
			exit;
		}
		
		$this->render('database');
    }
    
    function tables() {
		$db = ConnectionManager::getDataSource('default');
        $result = $db->query('show tables');
		
        if(empty($result)) {
	        if(!$db->isConnected()) {
	            echo 'Could not connect to database. Please check the settings in app/config/database.php and try again';
	            exit;
	        }
			$this->__executeSQLScript($db,CONFIGS.'sql'.DS.'gclms.sql');
        }
		$this->redirect('/install/configuration');
		exit;
    }
    
    function configuration() {
		if(!empty($this->data['App']['name']) && !empty($this->data['App']['domain']) && !empty($this->data['App']['administrator_email'])) {
			$content = "<?\n" 
					. "Configure::write('App.name', '" . $this->data['App']['name'] . "');\n"
					. "Configure::write('App.domain', '" . $this->data['App']['domain'] . "');\n"
					. "Configure::write('App.administrator_email', '" . $this->data['App']['administrator_email'] . "');\n"
					. "Configure::write('debug', 1);";
			
			file_put_contents(CONFIGS.'options.php', $content);    		
		}
		
	   	if(file_exists(CONFIGS.'options.php'))
	    	$this->redirect('/install/first_user', null, true);   
    }
    
    function first_user() {		  
        $db = ConnectionManager::getDataSource('default');
        if(!$db->isConnected()) {
            echo 'Could not connect to database. Please check the settings in app/config/database.php and try again';
            exit();
        }

        if(!empty($this->data['User']['email'])
				&& !empty($this->data['User']['password'])
				&& !empty($this->data['User']['first_name'])
				&& !empty($this->data['User']['last_name'])
				&& !empty($this->data['User']['email'])) {

			$this->User =& ClassRegistry::init('User');
	
			$this->data['User']['password'] = Security::hash(Configure::read('Security.salt') . $this->data['User']['password'], 'sha1');
			
			$this->User->save(array(
				'email' => $this->data['User']['email'],
				'username' => $this->data['User']['username'],
				'password' => $this->data['User']['password'],
				'first_name' => $this->data['User']['first_name'],
				'last_name' => $this->data['User']['last_name'],
				'verified' => 1
			));
			
			$this->Permission =& ClassRegistry::init('Permission');
			
			$this->Permission->save(array(
				'user_id' => $this->User->id,
				'model' => '*',
				'crud' => array('_create' => 1,'_read' => 1,'_update' => 1,'_delete' => 1)
			));
		}
   		if(count($db->query('select id from users;')))
			$this->redirect('/install/congratulations', null, true);
    }    
    
    function congratulations() {
        file_put_contents(CONFIGS.'installed.txt', date('Y-m-d, H:i:s'));
    }

    function __executeSQLScript($db, $fileName) {
        $statements = file_get_contents($fileName);
        $statements = explode(';', $statements);

        foreach ($statements as $statement) {
            if (trim($statement) != '') {
                $db->query($statement);
            }
        }
		
		return true;
    }
}