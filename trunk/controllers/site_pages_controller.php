<?
class SitePagesController extends AppController {
    var $uses = array('SitePage');

	function beforeFilter() {
		$this->Breadcrumbs->addHomeCrumb();
		$this->Breadcrumbs->addSiteAdministrationCrumb();
		$this->Breadcrumbs->addCrumb('Site Pages','/administration/site_pages');
		
		parent::beforeFilter();
		
		if(!Permission::check('SiteAdministration')) {
			$this->cakeError('permission');
		}
	}
	
	function administration_index() {
		$this->data = $this->SitePage->find('all',array(
			'order' => 'SitePage.title'
		));
	}
	
	function administration_edit($id) {
		$this->data = $this->SitePage->find('first',array(
			'SitePage.id' => $id
		));
	}
}