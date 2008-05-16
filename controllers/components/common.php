<?
class CommonComponent extends Object {
    function startup(&$controller){
		$this->controller = &$controller;
    }
	
	function index() {
	    $this->controller->table();
	   
	    if($this->controller->RequestHandler->isAjax())
	    	$this->controller->render('table','ajax');
	}
	
	function table() {
		$data = $this->controller->paginate();
		$this->controller->set(compact('data'));
	}
	
    function add($model = null) {
		if(empty($model))
			$model = $this->controller->modelNames[0];

		if(!empty($this->controller->data)) {
			if($this->controller->{$model}->save($this->data)) {
				if(!empty($this->itemName))
					$this->controller->Notifications->add(__(ucfirst(low($this->controller->itemName)) . ' successfully added.',true));
				$this->controller->data[$model]['id'] = $this->controller->{$model}->id;
				$this->controller->afterSave();
			} else {
				if(!empty($this->controller->itemName))
					$this->controller->Notifications->add(__('There was an error when attempting to add the ' . low($this->controller->itemName) . '.',true),'error');
			}
		}
    }	
	
    function edit($id = null, $model = null) {
		if(empty($model))
			$model = $this->controller->modelNames[0];

		if(!empty($this->data)) {
			$this->controller->{$model}->id = $id;
			$this->controller->data[$model]['id'] = $id; // For accessibility outside of this method
			if($this->controller->{$model}->save($this->controller->data)) {
				if(!empty($this->itemName))
					$this->controller->Notifications->add(__(ucfirst(low($this->controller->itemName)) . ' successfully saved.',true));
				$this->afterSave();
			} else {
				if($id)
					$this->controller->data[$model]['id'] = $id;
				if(!empty($this->controller->itemName))
					$this->controller->Notifications->add(__('There was an error when attempting to edit the ' . low($this->controller->itemName) . '.',true),'error');
			}
		} else {
			$this->data = $this->{$model}->findById($id);
		}
    }
	
    function delete($id) {
        if($this->controller->{$this->controller->uses[0]}->delete($id) && !empty($this->itemName))
			$this->controller->Notifications->add(__(ucfirst(low($this->itemName)) . ' successfully deleted.',true));
		else if(!empty($this->itemName))
			$this->controller->Notifications->add(__('There was an error when attempting to delete the ' . low($this->itemName) . '.',true),'error');
		$this->controller->afterDelete();
    }
	
	function afterSave() {
		if(empty($this->controller->redirect)) {
			if(!empty($this->controller->params['administration']))
				$this->controller->params['administration'] = '/' . $this->controller->params['administration'];
			$this->controller->redirect(@$this->params['administration'] . $this->controller->viewVars['groupAndCoursePath'] . '/' . Inflector::underscore($this->controller->name));
		} else
			$this->controller->redirect($this->controller->redirect);
		exit;
	}
}