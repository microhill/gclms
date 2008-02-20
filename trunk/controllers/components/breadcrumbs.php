<?
class BreadcrumbsComponent extends Object {
	var $crumbs = array();
    
    function startup(&$controller){
    	$this->controller = &$controller;

    }
    
	function addCrumb($title, $link) {
		if(!empty($this->controller) && $this->controller->params['isAjax'])
			return false;
		$this->crumbs[$title] = $link;
		return true;
	}
	
	function addStudentCenterCrumb() {
		$this->addCrumb('Student Center','/');
	}
	
	function addSiteAdministrationCrumb() {
		$this->addCrumb('Site Administration','/administration/panel');
	}	
	
	function addGroupCrumb() {
		$this->addCrumb($this->controller->viewVars['group']['name'],'/' . $this->controller->viewVars['group']['web_path']);
	}
	
	function addCourseCrumb() {
		$url = $this->controller->viewVars['groupAndCoursePath'];
		
		$this->addCrumb($this->controller->viewVars['course']['title'],$url);
	}

	function addLessonCrumb() {
		$url = $this->controller->viewVars['groupAndCoursePath'];
			
		//$this->addCrumb(__('Lesson',true) . ' ' . $this->controller->viewVars['lesson']['order'] . ': ' .  $this->controller->viewVars['lesson']['title'], $url . '/classroom/lesson/' . $this->controller->viewVars['lesson']['id']);
		$this->addCrumb($this->controller->viewVars['lesson']['title'], $url . '/classroom/lesson/' . $this->controller->viewVars['lesson']['id']);
	}

	function getTrail() {
		if(!$this->controller->params['isAjax'] && !empty($this->crumbs))
			return $this->crumbs;
		else
			return array();
	}
}