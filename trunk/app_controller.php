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
		$this->L10n = new L10n();

		if(!$this->Session->check('Config.language')) {
			$this->Session->write('Config.language','en');
       	}

		$this->L10n->get($this->Session->read('Config.language'));
		
		if(Configure::read('Configuration.database_set') && $this->name == 'Update') {
			return false;
		}

    	$this->paginate = am($this->paginateDefaults,$this->paginate);
       	$this->set('itemName', @$this->itemName);
       	$this->MyAuth->fields = array('username' => 'email', 'password' => 'password');
       	$this->MyAuth->logoutRedirect = '/';
       	$this->MyAuth->loginRedirect = '/';
       	$this->MyAuth->logoutAction = array('controller'=>'users','action'=>'logout');
       	$this->MyAuth->loginAction = array('controller'=>'users','action'=>'login');
       	$this->MyAuth->authorize = 'controller';

		$this->loadSessionVariables();

       	$group = !empty($group['Group']['web_path']) ? $group['Group']['web_path'] : null;
		$cakeAdmin = isset($this->params[Configure::read('Routing.admin')]) ? Configure::read('Routing.admin') : null;

       	$this->set('user', $this->Session->read('Auth.User'));
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
		}

		if(isset($this->params['url']['framed'])) {
			$this->layout = 'framed';
		}
    }

    function loadSessionVariables() {
       	// Group
       	if(isset($this->params['group'])) {
			$this->Group->contain();
			$group = $this->Group->find(array('Group.web_path' => $this->params['group']),array('id','name','web_path','external_web_address','logo','logo_updated','description','web_path'));
			$this->set('group',$group['Group']);
       	}
    	$this->set('groupWebPath', isset($this->viewVars['group']['web_path']) ? '/' . $this->viewVars['group']['web_path'] : null);
		
		// Course
       	if(!empty($this->params['course'])) {
			$this->Course->contain('id','group_id','title','web_path','description','language','redistribution_allowed','commercial_use_allowed','derivative_works_allowed','css');
			$course = $this->Course->find(array("Course.web_path" => $this->params['course']));
			$this->set('course',$course['Course']);
       	}
    	$this->set('courseWebPath', isset($this->viewVars['course']['web_path']) ? '/' . $this->viewVars['course']['web_path'] : null);
						
		// Class
       	if(!empty($this->params['class'])) {
       		$this->VirtualClass->contain();
       		$facilitated_class = $this->VirtualClass->find($this->params['class']);
			$this->Session->write('VirtualClass.' . $this->params['class'],$facilitated_class['VirtualClass']);
       	}
       	if(isset($this->params['class'])) { // && $this->Session->check('VirtualClass.' . $this->params['class'])
			$this->set('facilitated_class', $this->Session->read('VirtualClass.' . $this->params['class']));
       	}
    	$this->set('classWebPath', isset($this->viewVars['facilitated_class']['id']) ? '/' . $this->viewVars['facilitated_class']['id'] : null);
				
    	$this->set('groupAndCoursePath', $this->viewVars['groupWebPath'] . $this->viewVars['courseWebPath'] . $this->viewVars['classWebPath']);
		
		// Offline
		$this->set('offline',isset($this->params['url']['offline']));
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

		if(isset($this->passedArgs['lesson'])) {
			$this->Breadcrumbs->addLessonCrumb();
		}
    }

    function administration_add($model = null) { $this->add($model); }
    function add($model = null) { $this->Common->add($model); }
	
    function administration_index() {$this->index();}
	function index() { $this->Common->index(); }
	function table() { $this->Common->table(); }

    function administration_edit($id = null, $model = null) { $this->Common->edit($id,$model); }	
    function edit($id = null, $model = null) { $this->Common->edit($id,$model); }

	function afterSave() { $this->Common->afterSave(); }

    function administration_delete($id) { $this->Common->delete($id); }
    function delete($id) { $this->Common->delete($id); }

    function afterDelete() { $this->afterSave(); }

	function isAuthorized() {
 		$user = $this->viewVars['user'];
    	if($user['super_administrator'])
    		return true;

    	if(!$user['verified']) {
    		$this->Notifications->add(__('Your account has not yet been verified. Please check your e-mail.',true),'error');
    	}

    	return true;
	}
}