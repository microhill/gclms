<?
class StatisticsController extends AppController {
	var $uses = array();
	var $components = array('Security');
	
	function beforeRender() {
		$this->Breadcrumbs->addHomeCrumb();
		$this->Breadcrumbs->addSiteAdministrationCrumb();
		parent::beforeRender();
	}
	
	function administration_index() {
		if(!Permission::check('SiteAdministration')) {
			$this->cakeError('permission');
		}
		
		$group_count = $this->Group->find('count');
		$this->set('group_count',$group_count);
		
		$course_count = $this->Course->find('count');
		$this->set('course_count',$course_count);	
		
		$user_count = $this->User->find('count');
		$this->set('user_count',$user_count);
		
		App::import('Model','Node');
		$this->Node = new Node;
		
		$pages_created = array();
		for($x = 1; $x <= 31; $x++) {
			$pages_created[$x] = $this->Node->find('count',array(
				'conditions' => array(
					'Node.created >' => date('Y-m-d G:H:s', strtotime('-' . $x .' days')),
					'Node.created <' => date('Y-m-d G:H:s', strtotime('-' . $x + 1 .' days'))		
				)
			));
		}
		$this->set('pages_created',array_reverse($pages_created));
		
		$users_created = array();
		for($x = 1; $x <= 31; $x++) {
			$users_created[$x] = $this->User->find('count',array(
				'conditions' => array(
					'User.created >' => date('Y-m-d G:H:s', strtotime('-' . $x .' days')),
					'User.created <' => date('Y-m-d G:H:s', strtotime('-' . $x + 1 .' days'))		
				)
			));
		}
		$this->set('users_created',array_reverse($users_created));
		
		App::import('Model','ForumPost');
		$this->ForumPost = new ForumPost;
		
		$forum_posts_created = array();
		for($x = 1; $x <= 31; $x++) {
			$forum_posts_created[$x] = $this->ForumPost->find('count',array(
				'conditions' => array(
					'ForumPost.created >' => date('Y-m-d G:H:s', strtotime('-' . $x .' days')),
					'ForumPost.created <' => date('Y-m-d G:H:s', strtotime('-' . $x + 1 .' days'))		
				)
			));
		}
		$this->set('forum_posts_created',array_reverse($forum_posts_created));
	}
}