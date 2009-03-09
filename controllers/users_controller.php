<?
uses('Sanitize');

class UsersController extends AppController {
    var $uses = array('User');
	var $helpers = array('MyPaginator','UserDisplay');
	var $itemName = 'User';
	var $paginate = array('order' => 'email');
	var $components = array('Notifications');

	function beforeFilter() {
		//$this->Auth->allowedActions = array('register','choose_language','reset_password','verify','logout');
		$this->Breadcrumbs->addHomeCrumb();

		$cake_admin = isset($this->params[Configure::read('Routing.admin')]) ? Configure::read('Routing.admin') : null;
		if($cake_admin) {
			$this->Breadcrumbs->addCrumb('Site Administration','/administration/panel');
			$this->Breadcrumbs->addCrumb('Users','/administration/users');
		}
		
		Configure::load('s3');
		$this->set('bucket',Configure::read('S3.bucket'));
		$this->set('accessKey',Configure::read('S3.accessKey'));
		$this->set('secretKey',Configure::read('S3.secretKey'));
		
		parent::beforeFilter();
	}
	
	function administration_add() {
		$this->Common->add();	
	}
	
	function administration_index() {
		if(!Permission::check('SiteAdministration')) {
			$this->cakeError('permission');
		}

		$this->Common->index();	
	}
	
	function table($page = 1,$limit = 15,$sort = 'username',$direction = 'ASC'){
		$this->data = $this->User->find('all',array(
			'fields' => array('id','username','first_name','last_name','email'),
			'limit' => $limit,
			'sort' => $sort . ' ' . $direction,
			'recursive' => false
		));
	}
	
	function administration_dropdown($email_or_username) {
		$this->User->contain();
		$user = $this->User->find('first',array(
			'conditions' => array(
				'or' => array(
					'User.email LIKE ' => Sanitize::paranoid($email_or_username) . '%"',
					'User.username LIKE ' => Sanitize::paranoid($email_or_username) . '%"'
				)
			)
		));
		
		if(count($user) != 1)
			die();
		$this->set(compact('user'));
	}
	
	function search($email_or_username) {
		$this->User->contain();
		$user = $this->User->find('first',array(
			'conditions' => array(
				'User.email LIKE ' => Sanitize::paranoid($email_or_username) . '%"',
				'or' => array('User.username LIKE ' => Sanitize::paranoid($email_or_username) . '%"')
			)
		));
		
		if(count($user) != 1)
			die();
		$this->set(compact('user'));
	}
	
	function view() {
		//User
		$user = $this->User->find('first',array(
			'conditions' => array('User.username' => $this->params['user']),
			'contain' => false
		));
		if(empty($user)) {
			die('User not found.');
		}
		$this->set('user',$user);
		$this->Breadcrumbs->addCrumb($this->params['user'],'/user/' . $this->params['user']);
		
		//My groups and classes
		$this->set('my_groups',$this->User->findAllGroups($user['User']['id']));
		$this->set('my_classes',$this->User->findAllClasses($user['User']['id']));
		
		//Notebook entries
		$this->NotebookEntry =& ClassRegistry::init('NotebookEntry');
		
		if(User::get('username') == $this->params['user']) {
			$conditions = array('NotebookEntry.user_id');
		} else {
			$conditions = array('NotebookEntry.user_id','NotebookEntry.private' => 0);
		}
		$this->NotebookEntry->contain();
		$notebook_entries = $this->NotebookEntry->find('all',array(
			'conditions' => $conditions,
			'limit' => 5,
			'order' => 'NotebookEntry.created DESC'
		));
		$this->set('notebook_entries',$notebook_entries);
	}
    
	function verify($code) {
		$code = trim($code);
		if(empty($code))
			die();
		$user = $this->User->findByVerificationCode($code);
		if(empty($user['User']['id'])) {
			$this->Notifications->add(__('Verification code not found.',true),'error');
			$this->redirect('/');
		} else {
			$this->User->id = $user['User']['id'];
			$this->User->saveField('verified',1);
			$this->Notifications->add(__('Account verified. You can now log in.',true));

			/*
			$user = $this->Session->read('Auth.User');
			$user['verified'] = 1;
			$this->set('user', $user);
			$this->Session->write('Auth.User',$user);
			*/
			
			$this->redirect('/');
		}
	}

	function login() {
		if(!empty($this->data)) {
			if($user = $this->User->authenticate($this->data)) {
				$this->Session->write('User',$user);
			} else {
				$this->Notifications->add('Error when attempting to log in','error');
			}
		} else {
			die('What, you think you can login without any login credentials?');
		}
		$this->redirect(Controller::referer());
	}
	
	function choose_language() {
		$this->Session->write('Language.default',Sanitize::paranoid($this->data['User']['language']));
		$this->redirect('/', null, true);
	}

    function logout() {
		$this->Session->destroy();
		$this->redirect('/');
    }
    
    function reset_password() {
    	if(!empty($this->data)) {
    		$this->User->contain();
			$user = $this->User->findByEmail($this->data['User']['email']);
    		if(empty($user['User']['id'])) {
	    		$this->Notifications->add(__('Username could not be found.',true),'error');
    		} else {
    			$chars = array('2','3','4','5','6','7','8','9','a','b','c','d','e','f','g','h','i','j','k','m','n','p','q','r','s','t','u','v','w','x','y','z');
    			shuffle($chars);
    			$newPassword = substr((implode('',$chars)),0,8);
    			
    			$this->User->id = $user['User']['id'];
    			$this->User->save(array(
    				'password' => Security::hash(Configure::read('Security.salt') . $newPassword, 'sha1')
    			));
    			
    			mail($user['User']['email'],__('Your password has been reset',true),sprintf(__('The password for %s has been reset to %s',true),$user['User']['email'],$newPassword), 'From: aaronshaf@gmail.com');
				$this->Notifications->add(__('Your password has been reset. Please check your e-mail.',true));
				$this->redirect('/');
    		}    		
    	}
    } 
}