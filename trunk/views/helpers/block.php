<?
class BlockHelper extends AppHelper {	
	var $sections = array();	
	var $blocks = array();

	function add($options) {
		$options = am(array(
			'section' => 'primary_column'
		),$options);
		$this->blocks[$options['name']] = $options;

		if(empty($this->sections[$options['section']])) {
			$this->sections[$options['section']] = array();
		}
		
		array_push($this->sections[$options['section']],$options['name']);
	}
	
	function render($name) {
		$view =& ClassRegistry::getObject('view');
		
		return $view->element('block',array(
			'title' => $this->blocks[$name]['title'],
			'content' => $this->blocks[$name]['content']
		));
	}
	
	function renderSection($section) {
		$html = '';
		if(!empty($this->sections[$section])) {
			foreach($this->sections[$section] as $menu) {
				$html .= $this->render($menu);
			}	
		}
		
		return $html;
	}
}