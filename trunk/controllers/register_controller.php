<?
class RegisterController extends AppController {
    var $uses = array('User');

    function beforeFilter() {
		$this->MyAuth->allowedActions = array('*');
		//$this->Security->requirePost('save');
		$this->Breadcrumbs->addHomeCrumb();
		parent::beforeFilter();
    }
	
    function index() {
    	if(!empty($this->data)) {
			$this->User->id = null;
			if($this->User->save($this->data)) {
				$this->Notifications->add(__('Thank you for registering as a student. Please check your e-mail to activate your student account.',true));
				$this->redirect('/');
			}
    	}
	}
}