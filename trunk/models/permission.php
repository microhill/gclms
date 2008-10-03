<?
class Permission extends AppModel {
    var $belongsTo = array('User','Group','Course','VirtualClass');
	
	function save($data) {
		$this->id = null;
		
		$crud = $data['crud'];
		unset($data['crud']);
		$this->contain('id');	
		$permission = $this->find('first',array(
			'conditions' => array($data),
			'fields' => 'id'
		));
		if(!empty($permission)) {
			$this->id = $permission['Permission']['id'];
			if(empty($crud) || (empty($crud['_create']) && empty($crud['_read']) && empty($crud['_update']) && empty($crud['_delete']))) {
				$this->delete($permission['Permission']['id']);
				return true;
			}
		}

		$data = array_merge($data,$crud);

		return parent::save($data);
	}
}