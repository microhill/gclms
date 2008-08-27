<?
App::import('Helper','Time');

class MyTimeHelper extends TimeHelper {	
	function niceShortDate($date_string = null) {
		$date = $date_string ? $this->fromString($date_string) : time();

		$y = $this->isThisYear($date) ? '' : ', Y';

		if ($this->isToday($date)) {
			$ret = "Today";
		} elseif ($this->wasYesterday($date)) {
			$ret = "Yesterday";
		} else {
			$ret = date("F jS{$y}", $date);
		}

		return $this->output($ret);
	}
	
	function niceShort($date_string = null) {
		$date = $date_string ? $this->fromString($date_string) : time();

		$y = $this->isThisYear($date) ? '' : ' Y';

		if ($this->isToday($date)) {
			$ret = "Today, " . date("g:i a", $date);
		} elseif ($this->wasYesterday($date)) {
			$ret = "Yesterday, " . date("g:i a", $date);
		} else {
			$ret = date("M jS{$y}, g:i a", $date);
		}

		return $this->output($ret);
	}	
}