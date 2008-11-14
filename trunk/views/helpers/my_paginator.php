<?
class MyPaginatorHelper extends Helper {	
	function options () {
		
	}
	
	function sort () {
		
	}

	/*
	function sort($title, $key = null, $options = array()) {
		if(@$this->passedArgs['sort'] == $key) {
			$options['class'] = $this->passedArgs['direction'] == 'asc' ? 'SortAsc' : 'SortDesc';	
		}
		//pr($options);
		return parent::sort($title,$key,$options);
	}
	function __pagingLink($which, $title = null, $options = array(), $disabledTitle = null, $disabledOptions = array()) {
		$check = 'has' . $which;
		if (!$this->{$check}())
			return false;

		return parent::__pagingLink($which, $title, $options, $disabledTitle, $disabledOptions);
	}
	
	function link($title, $url = array(), $options = array()) {
		$options = am(array('model' => null, 'escape' => true), $options);
		$model = $options['model'];
		unset($options['model']);

		if (!empty($this->options)) {
			$options = am($this->options, $options);
		}

		$paging = $this->params($model);
		$urlOption = null;
		if (isset($options['url'])) {
			$urlOption = $options['url'];
			unset($options['url']);
		}
		$url = am(array_filter(Set::diff(am($paging['defaults'], $paging['options']), $paging['defaults'])), $urlOption, $url);

		if (isset($url['order'])) {
			$sort = $direction = null;
			if (is_array($url['order'])) {
				list($sort, $direction) = array($this->sortKey($model, $url), current($url['order']));
			}
			unset($url['order']);
			$url = am($url, compact('sort', 'direction'));
		}
		
		$url = am(array('page' => $this->current($model)), $url);
		
		$newUrl = $url[0];
		if(!empty($url['page']))
			$newUrl .= '/page:' . $url['page'];
		if(!empty($url['sort']))
			$newUrl .= '/sort:' . $url['sort'];
		if(!empty($url['direction']))
			$newUrl .= '/direction:' . $url['direction'];
		
		return $this->Html->link($title, $newUrl, $options);
	}
	*/
}