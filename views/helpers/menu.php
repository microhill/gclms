<?
class MenuHelper extends AppHelper {	
	var $helpers = array('Block');
	
	var $sections = array();	
	var $menus = array();
	var $menuItems = array();

	function addMenu($options) {
		$options = am(array(
			'section' => 'primary_column'
		),$options);
		$this->menus[$options['name']] = $options;

		if(empty($this->sections[$options['section']])) {
			$this->sections[$options['section']] = array();
		}
		array_push($this->sections[$options['section']],$options['name']);
	}

	function addMenuItem($name,$options) {		
		if(empty($this->menuItems[$name])) {
			$this->menuItems[$name] = array();
		}
		
		array_push($this->menuItems[$name],$options);
	}

	function renderSectionToBlocks($section) {
		//$view =& ClassRegistry::getObject('view');
		
		foreach($this->sections[$section] as $name) {
			$options = $this->menus[$name];
			
			$html = '<ul';
			if(!empty($options['class']))
				$html .= ' class="' . $options['class'] . '"';
			$html .= '>';
	
			if(!empty($this->menuItems[$name])) {
				foreach($this->menuItems[$name] as $menuItem) {
					$html .= '<li ';
	
					if(!empty($menuItem['active']))
						$menuItem['class'] .= ' gclms-active';
	
	
					if(!empty($menuItem['class']))
						$html .= 'class="' . $menuItem['class'] . '"';
					$html .= '>';
					
					$html .= '<a href="' . $menuItem['url'] . '">';
					$html .= $menuItem['content'];
					$html .= '</a>';
					
					$html .= '</li>';
				}
					
				$html .= '</ul>';

				$this->Block->add(array(
					'name' => $name,
					'section' => $section,
					'title' => $options['title'],
					'content' => $html
				));
			}
		}
	}
	
	/*
	function renderSection($section) {
		$html = '';
		if(!empty($this->sections[$section])) {
			foreach($this->sections[$section] as $menu) {
				$html .= $this->renderMenu($menu);
			}	
		}
		
		return $html;
	}
	*/
}