<?
uses('Sanitize');

class UsersController extends AppController {
    var $uses = array('User');
	var $helpers = array('Paginator','MyPaginator');
	var $itemName = 'User';
	var $paginate = array('order' => 'email');
	var $components = array('Notifications','MyAuth');

	function beforeFilter() {
		$this->MyAuth->allowedActions = array('register','choose_language','reset_password','verify','logout');
		$this->Breadcrumbs->addHomeCrumb();

		$cake_admin = isset($this->params[Configure::read('Routing.admin')]) ? Configure::read('Routing.admin') : null;
		if($cake_admin)
			$this->Breadcrumbs->addCrumb('Site Administration',array($cake_admin=>$cake_admin,'controller'=>'panel'));
		if($this->action != Configure::read('Routing.admin') . '_index' && $this->action != 'login' && $this->action != 'register') {
			$this->Breadcrumbs->addCrumb('Users',array($cake_admin=>$cake_admin,'action'=>'index'));
		}
		parent::beforeFilter();
	}
	
	function administration_dropdown($name) {
		$this->User->contain();
		$user = $this->User->findAll('User.Username LIKE "' . Sanitize::paranoid($name) . '%"',array('email'));
		if(count($user) != 1)
			die();
		$this->set(compact('user'));
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
	}
	
	function choose_language() {
		$this->Session->write('Config.language',Sanitize::paranoid($this->data['User']['language']));
		$this->redirect('/', null, true);
	}

    function logout() {
		$this->MyAuth->logout();
		$this->redirect('/');
		exit;
    }
    
    function reset_password() {
    	if(!empty($this->data)) {
    		$user = $this->User->findByUsername($this->data['User']['email']);
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