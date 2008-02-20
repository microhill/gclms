<?
class LicenseHelper extends AppHelper {
	function getUrl($redistribution_allowed,$commercial_use_allowed,$derivative_works_allowed) {
		if(!$redistribution_allowed)
			return false;

		$url = 'http://creativecommons.org/licenses/';
		if($commercial_use_allowed) {
			if($derivative_works_allowed == 0) {
				//Attribution-NoDerivs
				$url .= 'by-nd/3.0/';
			} else if ($derivative_works_allowed == 1){
				//Attribution
				$url .= 'by/3.0/';
			} else if ($derivative_works_allowed == 2){
				//Attribution-ShareAlike
				$url .= 'by-sa/3.0/';
			}
		} else {
			if($derivative_works_allowed == 0) {
				//Attribution-NonCommercial-NoDerivs
				$url .= 'by-nc-nd/3.0/';
			} else if ($derivative_works_allowed == 1){
				//Attribution-NonCommercial
				$url .= 'by-nc/3.0/';
			} else if ($derivative_works_allowed == 2){
				//Attribution-NonCommercial-ShareAlike
				$url .= 'by-nc-sa/3.0/';
			}
		}

		return $url;
	}
}