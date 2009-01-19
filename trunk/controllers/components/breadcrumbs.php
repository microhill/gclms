<?
class BreadcrumbsComponent extends Object {
	var $crumbs = array();
    
    function startup(&$controller){
		$this->controller = &$controller;
    }
    
	function addCrumb($title, $options) {
		if(!empty($this->controller) && $this->controller->params['isAjax'])
			return false;
		$this->crumbs[$title] = $options;
		return true;
	}
	
	function addHomeCrumb() {
		$this->addCrumb('Home','/');
	}
	
	function addSiteAdministrationCrumb() {
		$this->addCrumb('Site Administration','/administration');
	}	
	
	function addGroupCrumb() {
		$this->addCrumb(Group::get('name'),'/' . Group::get('web_path'));
	}
	
	function addCourseCrumb() {
		$url = $this->controller->viewVars['groupAndCoursePath'];
		
		$this->addCrumb($this->controller->viewVars['course']['title'],$url);
	}

	function getTrail() {		
		if(!$this->controller->params['isAjax'] && !empty($this->crumbs))
			return $this->crumbs;
		else
			return array();
	}
}