<?
class ForumTopicsController extends AppController {
    var $uses = array('ForumPost','Forum');
	var $helpers = array('Time','MyTime','Text');

	function beforeRender() {
		$this->defaultBreadcrumbsAndLogo();
		$this->Breadcrumbs->addCrumb('Forums','/' . $this->viewVars['groupAndCoursePath'] . '/forums');
		parent::beforeRender();
	}
	
	function add() {
		$this->set('forum',$this->Forum->findById($this->passedArgs['forum']));
		
		if(!empty($this->data)) {
			$this->data['ForumPost']['user_id'] = User::get('id');
		}

		return parent::add('ForumPost');
	}

	function afterSave() {
		$this->redirect($this->viewVars['groupAndCoursePath'] . '/forum_topics/view/' . $this->ForumPost->id);	
	}

	function delete($id) {
		$this->redirect = $this->viewVars['groupAndCoursePath'] . '/forums/view/' . $this->ForumPost->field('forum_id',array('id' => $id));	
		return parent::delete($id);
	}
	
	function edit() {
		parent::edit('ForumPost');
		return $this->render('edit');
	}
	
	function view($id) {
		if(!empty($id) && !empty($this->data)) {
			$this->reply($id);
		}
		
		$this->ForumPost->contain(array('Forum','User','Reply' => 'User'));
		$this->data = $this->ForumPost->findById($id);
	}
	
	function reply($id) {
		if(!User::get('id')) {
			$this->redirect('/users/login?callback=' . Controller::referer());
		}
		
		$this->data['ForumPost'] = $this->data['Reply'];
		
		if(empty($this->data['ForumPost']['id'])) {
			$this->data['ForumPost']['origin_post_id'] = $id;
			$this->data['ForumPost']['forum_id'] = $this->ForumPost->field('forum_id',array('ForumPost.id' => $id));
			$this->data['ForumPost']['user_id'] = User::get('id');
			unset($this->data['ForumPost']['id']);
		} else {
			unset($this->data['ForumPost']['parent_post_id']);
			
			$originPostId = $this->ForumPost->field('origin_post_id',array('ForumPost.id' => $this->data['ForumPost']['id']));
			if(!empty($originPostId)) {
				$modifiedContentForTitle = ereg_replace("\n", " ", $this->data['Reply']['content']);  
				if(strlen($modifiedContentForTitle) > 35) {
					$this->data['ForumPost']['title'] = substr($this->data['Reply']['content'],0,35) . '...';	
				} else {
					$this->data['ForumPost']['title'] = $this->data['Reply']['content'];
				}
			}
		}
		
		$this->redirect = Controller::referer();
		return parent::add('ForumPost');
	}
}