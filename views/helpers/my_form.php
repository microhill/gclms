<?
class MyFormHelper extends FormHelper {	
    function date($fieldName, $showEmpty = true, $attributes = null) {
    	//$this->html->setFormTag($tagName);
    	//if (@$validate[$this->html->model][$this->html->field] == VALID_NOT_EMPTY)
		//	$showEmpty = false;
				
		return $this->output(
			$this->month($fieldName, null, $attributes, $showEmpty) . ' '
				. $this->day($fieldName, null, $attributes, $showEmpty) . ' '
				. $this->year($fieldName,2007,2008,null,$attributes,false)
		);
    }

	function date_old($fieldName2, $dateFormat = 'DMY', $selected = null, $attributes = array(), $showEmpty = true) {
		$day	  = null;
		$month	  = null;
		$year	  = null;

		if (empty($selected)) {
			$selected = $this->value($fieldName);
		}

		if (!empty($selected)) {

			if (is_int($selected)) {
				$selected = strftime('%Y-%m-%d', $selected);
			}

			$pos = strpos($selected, '-');
			if ($pos !== false) {
				$date = explode('-', $selected);
				$days = explode(' ', $date[2]);
				$day = $days[0];
				$month = $date[1];
				$year = $date[0];
			} else {
				$days[1] = $selected;
			}
		}

		$elements = array('Day','Month','Year');
		if (isset($attributes['id'])) {
			if (is_string($attributes['id'])) {
				// build out an array version
				foreach ($elements as $element) {
					$selectAttrName = 'select' . $element . 'Attr';
					${$selectAttrName} = $selectAttr;
					${$selectAttrName}['id'] = $attributes['id'] . $element;
				}
			} elseif (is_array($attributes['id'])) {
				// check for missing ones and build selectAttr for each element
				foreach ($elements as $element) {
					$selectAttrName = 'select' . $element . 'Attr';
					${$selectAttrName} = $attributes;
					${$selectAttrName}['id'] = $attributes['id'][strtolower($element)];
				}
			}
		} else {
			// build the selectAttrName with empty id's to pass
			foreach ($elements as $element) {
				$selectAttrName = 'select' . $element . 'Attr';
				${$selectAttrName} = $attributes;
			}
		}

		$attributes = am(array('minYear' => null, 'maxYear' => null), $attributes);

		switch($dateFormat) {
			case 'DMY': // so uses the new selex
				$opt = $this->day($fieldName, $day, $selectDayAttr, $showEmpty) . '-' .
				$this->month($fieldName, $month, $selectMonthAttr, $showEmpty) . '-' . $this->year($fieldName, $attributes['minYear'], $attributes['maxYear'], $year, $selectYearAttr, $showEmpty);
			break;
			case 'MDY':
				$opt = $this->month($fieldName, $month, $selectMonthAttr, $showEmpty) . '-' .
				$this->day($fieldName, $day, $selectDayAttr, $showEmpty) . '-' . $this->year($fieldName, $attributes['minYear'], $attributes['maxYear'], $year, $selectYearAttr, $showEmpty);
			break;
			case 'YMD':
				$opt = $this->year($fieldName, $attributes['minYear'], $attributes['maxYear'], $year, $selectYearAttr, $showEmpty) . '-' .
				$this->month($fieldName, $month, $selectMonthAttr, $showEmpty) . '-' .
				$this->day($fieldName, $day, $selectDayAttr, $showEmpty);
			break;
			case 'Y':
				$opt = $this->year($fieldName, $attributes['minYear'], $attributes['maxYear'], $selected, $selectYearAttr, $showEmpty);
			break;
			case 'NONE':
			default:
				$opt = '';
			break;
		}
		return $opt;
	}
	
	/*
	function radio($fieldName, $options, $attributes = array()) {
		$inbetween = ' ';
		$this->setFormTag($fieldName);
		$attributes = $this->domId((array)$attributes);
		$this->__secure();

		if ($this->tagIsInvalid()) {
			$attributes = $this->addClass($attributes, 'form-error');
		}

		if (isset($attributes['type'])) {
			unset($attributes['type']);
		}
		
		if (isset($attributes['id'])) {
			//unset($attributes['id']);
		}

		$label = $this->field();
		if (isset($attributes['label'])) {
			$label = $attributes['label'];
			unset($attributes['label']);
		}

		$value = isset($attributes['value']) ? $attributes['value'] : $this->value($fieldName);
		$out = array();

		$count = 0;
		foreach ($options as $optValue => $optTitle) {
			$optionsHere = array('value' => $optValue);

			if ($value != null && $optValue == $value) { //This line was changed... recommend the change to the CakePHP team!
 	        	$optionsHere['checked'] = 'checked';
 	        }
			$parsedOptions = $this->_parseAttributes(array_merge($attributes, $optionsHere), null, '', ' ');
			$fieldName = $attributes['id'] . '_'.Inflector::underscore($optValue);
			$tagName = Inflector::camelize($fieldName);
			if($label) {
				$optTitle =  sprintf($this->Html->tags['label'], $tagName, null, $optTitle);
			}
			$out[] =  sprintf($this->Html->tags['radio'], $this->model(), $this->field(), $tagName, $parsedOptions, $optTitle);
			$count++;
		}

		return $this->output(join($inbetween, $out));
	}
	*/
	
	function radio_new($fieldName, $options = array(), $attributes = array()) {
		$attributes = $this->__initInputField($fieldName, $attributes);
		$this->__secure();
		$label = $this->field();
		$inbetween = null;

		if (isset($attributes['separator'])) {
			$inbetween = $attributes['separator'];
			unset($attributes['separator']);
		}

		if (isset($attributes['label'])) {
			$label = $attributes['label'];
			unset($attributes['label']);
		}

		$value = isset($attributes['value']) ? $attributes['value'] : $this->value($fieldName);
		$out = array();

		$count = 0;
		foreach ($options as $optValue => $optTitle) {
			$optionsHere = array('value' => $optValue);

			if ($value != null && $optValue == $value) {
				$optionsHere['checked'] = 'checked';
			}
			$parsedOptions = $this->_parseAttributes(array_merge($attributes, $optionsHere), array('name', 'type', 'id'), '', ' ');
			//$fieldName = $this->field() . '_'.Inflector::underscore($optValue);
			$fieldName = $attributes['id'] . '_'.Inflector::underscore($optValue); //changed
			$tagName = Inflector::camelize($fieldName);

			if($label) {
				$optTitle =  sprintf($this->Html->tags['label'], $tagName, null, $optTitle);
			}
			$out[] =  sprintf($this->Html->tags['radio'], $attributes['name'], $tagName, $parsedOptions, $optTitle);
			$count++;
		}

		//$out = sprintf($this->Html->tags['fieldset'], $label, join($inbetween, $out));
		return $this->output(join($inbetween, $out)); //changed
	}
}