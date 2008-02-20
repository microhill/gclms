<?php
/* Browser detection */

class Browser {
	public function agent() {
		$HTTP_USER_AGENT = env('HTTP_USER_AGENT');

		if (ereg('MSIE ([0-9].[0-9]{1,2})',$HTTP_USER_AGENT,$log_version)) {
			return 'IE';
		} else if (ereg( 'Opera ([0-9].[0-9]{1,2})',$HTTP_USER_AGENT,$log_version)) {
			return 'Opera';
		} else if (ereg( 'Mozilla/([0-9].[0-9]{1,2})',$HTTP_USER_AGENT,$log_version)) {
			return 'Mozilla';
		}
		return 'Other';
	}

	public function version() {
		$HTTP_USER_AGENT = env('HTTP_USER_AGENT');

		if (ereg('MSIE ([0-9].[0-9]{1,2})',$HTTP_USER_AGENT,$log_version)) {
			return (double) $log_version[1];
		} elseif (ereg( 'Opera ([0-9].[0-9]{1,2})',$HTTP_USER_AGENT,$log_version)) {
			return (double) $log_version[1];
		} elseif (ereg( 'Mozilla/([0-9].[0-9]{1,2})',$HTTP_USER_AGENT,$log_version)) {
			return (double) $log_version[1];
		}
		return 0;
	}

	public function platform() {
		$HTTP_USER_AGENT = env('HTTP_USER_AGENT');

		if (strstr($HTTP_USER_AGENT,'Win')) {
		  return 'Win';
		} else if (strstr($HTTP_USER_AGENT,'Mac')) {
		  return 'Mac';
		} else if (strstr($HTTP_USER_AGENT,'Linux')) {
		  return 'Linux';
		} else if (strstr($HTTP_USER_AGENT,'Unix')) {
		  return 'Unix';
		} else {
		  return 'Other';
		}
	}
}