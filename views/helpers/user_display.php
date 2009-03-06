<?
class UserDisplayHelper extends AppHelper {	
	function getAvatarImage($user) {
		if(!empty($user['User']))
			$user = $user['User'];
			
		if(empty($user['avatar']) || $user['avatar'] == 'default') {
			return '/img/icons/oxygen_refit/96x96/actions/stock_people.png';
		} else if ($user['avatar'] == 'gravatar'){
			return 'http://www.gravatar.com/avatar.php?gravatar_id=' . md5($user['email']) . '&size=96';
		} else if ($user['avatar'] == 'upload'){
			$view =& ClassRegistry::getObject('view');
			return 'http://' . $view->viewVars['bucket'] . '.s3.amazonaws.com/avatars/' . $user['id'] . '.jpg';
		}
	}
	
	function getDisplayName($user) {
		if(!empty($user['User']))
			$user = $user['User'];
			
		if($user['display_full_name']) {
			return $user['first_name'] . ' ' . $user['last_name'];			
		} else {
			return $user['username'];	
		}		
	}
}