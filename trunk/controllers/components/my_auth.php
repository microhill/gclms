<?
/*
include(CAKE_CORE_INCLUDE_PATH . DS . 'cake' . DS . 'libs' . DS . 'controller' . DS . 'components' . DS . 'auth.php');

class MyAuthComponent extends AuthComponent {
	var $components = array('Session', 'RequestHandler');
	
	function isAuthorized_old(&$controller, $type = null, $user = null) {
		return true;
	}
	
	function redirect($url = null) {
		if(!is_null($url)) {
			return $this->Session->write('Auth.redirect', $url);
		}
		if ($this->Session->check('Auth.redirect')) {
			$redir = $this->Session->read('Auth.redirect');
			$this->Session->delete('Auth.redirect');

			// Router::normalize()

			if ($redir == $this->loginAction
					|| $redir == $this->logoutAction) {
				$redir = $this->loginRedirect;
			}
		} else {
			$redir = $this->loginRedirect;
		}
		
		return $redir;
	}
}
*/