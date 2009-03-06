<?
class ProfileController extends AppController {
    var $uses = array('User');
	var $itemName = 'Profile';

	function beforeFilter() {
		Configure::load('s3');
		$this->set('bucket',Configure::read('S3.bucket'));
		$this->set('accessKey',Configure::read('S3.accessKey'));
		$this->set('secretKey',Configure::read('S3.secretKey'));

		parent::beforeFilter();
	}

	function beforeRender() {
		$this->Breadcrumbs->addHomeCrumb();
		$this->Breadcrumbs->addCrumb('Your Profile','/profile');
		parent::beforeRender();
	}
    
	function index() {
		$this->edit();
	}
	
	function edit($id = null) {
		if(empty($id)) {
			$id = User::get('id');
		}
		
		if(!empty($this->data)) {
			if($this->data['User']['avatar'] == 'upload')
				$this->resizeAndUploadAvatar();
			$this->User->id = $id;
			if($this->User->save($this->data['User'])) {
				$user = $this->User->find('first',array(
					'conditions' => array('id' => $id),
					'contain' => false
				));
				$this->Session->write('User',$user);
				User::store($this->Session->read('User'));
				$this->redirect('/user/' . User::get('username'));
			}
		} else {
			$this->data = User::getInstance();
		}
	}
	
	function afterSave() {
		$this->redirect('/');
		exit;
	}
	
	function resizeAndUploadAvatar() {
		App::import('Vendor','s3');
		//$key = 'courses/' . $this->viewVars['course']['id'] . '/' . $file;
		$s3 = new S3($this->viewVars['accessKey'], $this->viewVars['secretKey']);

		App::import('Vendor','phpthumb' . DS . 'phpthumbclass');
		$phpThumb = new phpThumb();
	
		$phpThumb->src = $this->params['data']['User']['avatar_file']['tmp_name'];
		$phpThumb->w = 96; //(!isset($_GET['w'])) ? 100 : $_GET['w'];;
		$phpThumb->h = 96; //(!isset($_GET['h'])) ? 100 : $_GET['h'];;
		$phpThumb->q = 80; //(!isset($_GET['q'])) ? 80 : $_GET['q'];;
		//$phpThumb->config_imagemagick_path = 'C:\Program Files\ImageMagick-6.3.6-Q16';
		$phpThumb->config_prefer_imagemagick = false;
		$phpThumb->config_output_format = 'jpg';
		$phpThumb->config_error_die_on_error = true;
		$phpThumb->config_temp_directory = TMP;
		$phpThumb->config_cache_directory = CACHE . 'avatars' . DS;
		$phpThumb->config_cache_disable_warning = true;
		$phpThumb->config_document_root = APP_PATH;
		$phpThumb->config_allow_src_above_docroot = true;
		$phpThumb->config_allow_src_above_phpthumb = true;
		//$phpThumb->phpThumbDebug = true;

		$phpThumb->cache_filename = $phpThumb->config_cache_directory . User::get('id') . '.jpg';

		if($phpThumb->GenerateThumbnail()) {
			$phpThumb->RenderToFile($phpThumb->cache_filename);
	    } else {
	        die('Failed: '.$phpThumb->error);
	    }

		$s3->putObjectFile($phpThumb->cache_filename, $this->viewVars['bucket'], 'avatars/' . User::get('id') . '.jpg', S3::ACL_PUBLIC_READ);
		unlink($phpThumb->cache_filename);
	}
}