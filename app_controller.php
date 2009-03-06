<?
App::import('Core', 'l10n');
App::import('Vendor', 'browserdetection'.DS.'browserdetection');

class AppController extends Controller {
	var $components = array('Common','Breadcrumbs','Languages','RequestHandler','Notifications');
	var $helpers = array('Html','Form','Ajax','Asset','Block','Menu');
	//var $uses = array('Group','Course','User','Permission');
	var $paginateDefaults = array('limit' => 12);
	var $css_for_layout = array();
	var $layout = 'gclms';

    function beforeFilter() {
		if($this->name == 'Install') { //!Configure::read('Config.database_set') && 
			return true;
		}
		
		$this->Group =& ClassRegistry::init('Group');
		$this->Course =& ClassRegistry::init('Course');
		$this->User =& ClassRegistry::init('User');
		$this->Permission =& ClassRegistry::init('Permission');

		$this->loadLocale();
		$this->loadVariables();

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
		//
		*/
		
       	$group = !empty($group['Group']['web_path']) ? $group['Group']['web_path'] : null;
		$cakeAdmin = isset($this->params[Configure::read('Routing.admin')]) ? Configure::read('Routing.admin') : null;

		if($this->Session->check('User')) {
			User::store($this->Session->read('User'));
			$this->Permission->cache('SiteAdministration');
		}

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

    function loadVariables() {
		if($this->Session->check('Language.default')) {
			$this->set('default_language',$this->Session->read('Language.default'));
		} else {
			$this->set('default_language','en');
		}

       	// Group
       	if(isset($this->params['group'])) {
			$this->Group->contain();
			$group = $this->Group->find('first',array(
				'conditions' => array('Group.web_path' => $this->params['group']),
				'fields' => array('id','name','web_path','external_web_address','logo','logo_updated','description','web_path')
			));
			Group::store($group);
       	}
		$groupWebPath = Group::get('web_path') ? '/' . Group::get('web_path') : null;
		
		// Course
       	if(!empty($this->params['course'])) {
			$course = $this->Course->find('first',array(
				'fields' => array('id','group_id','title','web_path','description','language','open','redistribution_allowed','commercial_use_allowed','derivative_works_allowed','css','published_status'),
				'conditions' => array('Course.web_path' => $this->params['course'],'Course.group_id' => Group::get('id'))
			));
			$this->set('course',$course['Course']); //needs purging
			Course::store($course);
       	}
		$courseWebPath = isset($this->viewVars['course']['web_path']) ? '/' . $this->viewVars['course']['web_path'] : null;
						
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
			$this->set('class', $class['VirtualClass']); //needs purging
			VirtualClass::store($class);
       	}
		$classWebPath = VirtualClass::get('id') ? '/' . VirtualClass::get('id') : null;
    	$this->set('groupAndCoursePath', $groupWebPath . $courseWebPath . $classWebPath);
		
		// Offline
		$this->set('offline',isset($this->params['url']['offline']));
		
		// Framed
		$this->set('framed',isset($this->params['url']['framed']));
		$this->set('framed_suffix',isset($this->params['url']['framed']) ? '?framed' : '');
    }
	
	function loadLocale() {
		if(Course::get('language')) {
			$this->Session->write('Config.language',Course::get('language'));
		} else if($this->Session->check('Language.default')) {
			$this->Session->write('Config.language',$this->Session->read('Language.default'));
       	} else {
       		$this->Session->write('Config.language','en');
       	}

		$this->L10n = new L10n();
		if(Course::get('language')) {
			$language = Course::get('language');
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
		}

		if(isset($this->params['course'])) {
			$this->Breadcrumbs->addCourseCrumb();
		}
    }

    function administration_add($model = null) { $this->add($model); }
    function add($model = null) { $this->Common->add($model); }
	
    function administration_index() {$this->Common->index();}
	function index() { $this->Common->index(); }

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