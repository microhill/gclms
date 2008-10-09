<?
uses('L10n');

App::import('Vendor', 'browserdetection'.DS.'browserdetection');
class AppController extends Controller {
    var $components = array('Common','Breadcrumbs','Languages','RequestHandler','Notifications');
	var $uses = array('Group','GroupAdministrator','Course','User');
	var $paginateDefaults = array('limit' => 12);
	var $helpers = array('Html','Form','Ajax','Asset');
	var $css_for_layout = array();

    function beforeFilter() {
		if(Configure::read('Configuration.database_set') && $this->name == 'Update') {
			return false;
		}

		$this->loadSessionVariables();
		
		$this->loadLocale();

    	$this->paginate = am($this->paginateDefaults,$this->paginate);
       	$this->set('itemName', @$this->itemName);

		/*
		$this->Auth->fields = array('username' => 'email', 'password' => 'password');
		$this->Auth->userScope = array('User.verified' => 1);
       	$this->Auth->logoutRedirect = '/';
       	$this->Auth->loginRedirect = '/';
       	//$this->Auth->logoutAction = array('controller'=>'users','action'=>'logout');
       	//$this->Auth->loginAction = array('controller'=>'users','action'=>'login');
       	$this->Auth->authorize = 'controller';
		$this->Auth->allow('*');
		*/
		
       	$group = !empty($group['Group']['web_path']) ? $group['Group']['web_path'] : null;
		$cakeAdmin = isset($this->params[Configure::read('Routing.admin')]) ? Configure::read('Routing.admin') : null;

		if($this->Session->check('User'))
			User::set($this->Session->read('User'));  

       	//$this->set('user', $this->Session->read('Auth.User'));
		$this->set('languages', $this->Languages->generateList());
		$this->set('showDefaultAddButton',true);
    }

    function beforeRender() {
		if ($this->viewPath != 'errors') {
			if(Browser::agent() == 'IE' && Browser::version() < 7)
				$this->Notifications->add(__('This application was not designed to work with older browsers like yours. Please download the latest version of <a href="http://www.microsoft.com/windows/downloads/ie/getitnow.mspx">Internet Explorer</a>, <a href="http://www.firefox.com/">Firefox</a>, <a href="http://www.apple.com/safari/download/">Safari</a>, or <a href="http://www.opera.com/">Opera</a>.',true),'error');
	
			$this->set('breadcrumbs',$this->Breadcrumbs->getTrail());
			$this->set('notifications',$this->Notifications->getAll());
			
	       	$this->set('css_for_layout', $this->css_for_layout);
		} else {
			$this->set('text_direction','ltr');
			$this->set('offline',isset($this->params['url']['offline']));
		}

		if(isset($this->params['url']['framed'])) {
			$this->layout = 'framed';
		}
    }

    function loadSessionVariables() {
		if($this->Session->check('Language.default')) {
			$this->set('default_language',$this->Session->read('Language.default'));
		} else {
			$this->set('default_language','en');
		}

       	// Group
       	if(isset($this->params['group'])) {
			$this->Group->contain();
			$group = $this->Group->find(array('Group.web_path' => $this->params['group']),array('id','name','web_path','external_web_address','logo','logo_updated','description','web_path'));
			$this->set('group',$group['Group']);
       	}
    	$this->set('groupWebPath', isset($this->viewVars['group']['web_path']) ? '/' . $this->viewVars['group']['web_path'] : null);
		
		// Course
       	if(!empty($this->params['course'])) {
			$course = $this->Course->find('first',array(
				'fields' => array('id','group_id','title','web_path','description','language','open','redistribution_allowed','commercial_use_allowed','derivative_works_allowed','css','published_status'),
				'conditions' => array('Course.web_path' => $this->params['course'],'Course.group_id' => $this->viewVars['group']['id'])
			));
			$this->set('course',$course['Course']);
       	}
    	$this->set('courseWebPath', isset($this->viewVars['course']['web_path']) ? '/' . $this->viewVars['course']['web_path'] : null);
						
		// Class
       	if(!empty($this->params['class'])) {
			if(empty($this->VirtualClass)) {
				App::import('Model','VirtualClass');
				$this->VirtualClass = new VirtualClass;
			}
			
       		$this->VirtualClass->contain();
       		$class = $this->VirtualClass->find('first',array(
				'conditions' => array('VirtualClass.id' => $this->params['class'])
			));
			$this->set('class', $class['VirtualClass']);
       	}
    	$this->set('classWebPath', isset($this->viewVars['class']['id']) ? '/' . $this->viewVars['class']['id'] : null);
    	$this->set('groupAndCoursePath', $this->viewVars['groupWebPath'] . $this->viewVars['courseWebPath'] . $this->viewVars['classWebPath']);
		
		// Offline
		$this->set('offline',isset($this->params['url']['offline']));
		
		// Framed
		$this->set('framed',isset($this->params['url']['framed']));
		$this->set('framed_suffix',isset($this->params['url']['framed']) ? '?framed' : '');
    }
	
	function loadLocale() {
		if(!empty($this->viewVars['course']['language'])) {
			$this->Session->write('Config.language',$this->viewVars['course']['language']);
		} else if($this->Session->check('Language.default')) {
			$this->Session->write('Config.language',$this->Session->read('Language.default'));
       	} else {
       		$this->Session->write('Config.language','en');
       	}

		$this->L10n = new L10n();		
		if(!empty($this->viewVars['course']['language'])) {
			$language = $this->viewVars['course']['language'];
		} else {
			$language = $this->Session->read('Config.language');	
		}
		$this->L10n->get($language);
		
		$this->set('text_direction',$this->Languages->getDirection($language));
	}

    function defaultBreadcrumbsAndLogo() {
		$this->Breadcrumbs->addHomeCrumb();

		if(isset($this->params['group'])) {
			$this->Breadcrumbs->addGroupCrumb();
			if(!empty($this->viewVars['group']['logo']) && $this->name != 'Classroom')
				$this->set('logo',$this->viewVars['group']['logo']);
		}

		if(isset($this->params['course'])) {
			$this->Breadcrumbs->addCourseCrumb();
		}
    }

    function administration_add($model = null) { $this->add($model); }
    function add($model = null) { $this->Common->add($model); }
	
    function administration_index() {$this->index();}
	function index() { $this->Common->index(); }
	function table() { $this->Common->table(); }

    function administration_edit($id = null, $model = null) { $this->Common->edit($id,$model); }	
    function edit($id = null, $model = null) { $this->Common->edit($id,$model); }

	//function afterSave() { $this->Common->afterSave(); }

    function administration_delete($id) { $this->Common->delete($id); }
    function delete($id) { $this->Common->delete($id); }

    //function afterDelete() { $this->afterSave(); }

	function isAuthorized() {
 		$user = User::get('super_administrator');
    		return true;

    	if(!User::get('verified')) {
    		$this->Notifications->add(__('Your account has not yet been verified. Please check your e-mail.',true),'error');
    	}

    	return true;
	}
}