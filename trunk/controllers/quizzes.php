<?
class QuizzesController extends AppController {
    var $uses = array('Node','Group','User','Course');
	var $itemName = 'Node';

	function beforeFilter() {
		parent::beforeFilter();
	
		$this->Permission->cache('GroupAdministration','Content');
		if(!Permission::check('Content')) {
			$this->cakeError('permission');
		}
	}

    function select() {		
		$this->Node->contain();
		$nodes =  $this->Node->findAllInCourse($this->viewVars['course']['id']);
		prd($nodes);
		$this->set(compact('nodes'));
		
		$this->render('select_popup','blank');
    }
}