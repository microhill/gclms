<?
class MenuHelper extends AppHelper {	
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

	function renderMenu($name = null) {
		$html = '<ul';
		if(!empty($this->menus[$name]['class']))
			$html .= ' class="' . $this->menus[$name]['class'] . '"';
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
			//prd($this->element);
			
			$view =& ClassRegistry::getObject('view');
			$view->element('panel');
			
			return $view->element('panel',array(
				'title' => $this->menus[$name]['label'],
				'content' => $html
			));
		}
	}
	
	function renderSection($section) {
		$html = '';
		if(!empty($this->sections[$section])) {
			foreach($this->sections[$section] as $menu) {
				$html .= $this->renderMenu($menu);
			}	
		}
		
		return $html;
	}
}