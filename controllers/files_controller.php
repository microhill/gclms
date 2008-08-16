<?
class FilesController extends AppController {
    var $uses = array('User','Group','Course');
	var $components = array('Notifications','RequestHandler');

	function beforeFilter() {
		Configure::load('S3');
		$this->set('bucket',Configure::read('S3.bucket'));
		$this->set('accessKey',Configure::read('S3.accessKey'));
		$this->set('secretKey',Configure::read('S3.secretKey'));

		parent::beforeFilter();
	}

    function upload() {
		if(empty($this->viewVars['course']['id']))
			exit(0);

		if(!empty($this->params['form']['Filedata']['tmp_name'])) {
			$newFile = ROOT . DS . APP_DIR . DS . 'files' . DS . 'courses' . DS . $this->viewVars['course']['id'] . DS . str_replace(' ','',low($this->params['form']['Filedata']['name']));
			$this->log('Old file: ' . $this->params['form']['Filedata']['tmp_name']);
			$this->log('New file: ' . $newFile);
			if(file_exists($newFile))
				unlink($newFile);
			rename($this->params['form']['Filedata']['tmp_name'], $newFile);
			echo "File successfully uploaded";
			//$this->Notifications->add(__('File successfully uploaded.',true));
		}
			
		exit(0);
    }

    function beforeRender() {
		$this->defaultBreadcrumbsAndLogo();
		$this->Breadcrumbs->addCrumb('Files','/' . $this->viewVars['groupAndCoursePath'] . '/files');

    	parent::beforeRender();
    }
	
	private function get_file_size($size) {
		$bytes = array('B','KB','MB','GB','TB');
		foreach($bytes as $val) {
			if($size > 1024){
				$size = $size / 1024;
			} else {
				break;
			}
		}
		return round($size) . ' ' . $val;
	}
	
	function create_thumbnail($file) {
		if(!isset($this->params['url']['render'])) {
			$this->render('creating_thumbnail');
			return true;
		}
		$this->__create_thumbnail($file);
		$this->redirect($this->viewVars['groupAndCoursePath'] . '/files');
	}
	
	private function __create_thumbnail($file, $source = null) {
		App::import('Vendor','s3');

		$key = 'courses/' . $this->viewVars['course']['id'] . '/' . $file;
		
		$s3 = new S3($this->viewVars['accessKey'], $this->viewVars['secretKey']);

		App::import('Vendor','phpthumb' . DS . 'phpthumbclass');
		$phpThumb = new phpThumb();
		
		if(!$source) {
			$path_parts = pathinfo($key);
			$S3Source = CACHE.'thumbs'.DS . md5($key) . '_source.' . $path_parts['extension'];
			$s3->getObject($this->viewVars['bucket'], $key, fopen($S3Source, 'wb'));
			$source = $S3Source;
		}
	
		$phpThumb->src = $source;
		$phpThumb->w = 100; //(!isset($_GET['w'])) ? 100 : $_GET['w'];;
		$phpThumb->h = 100; //(!isset($_GET['h'])) ? 100 : $_GET['h'];;
		$phpThumb->q = 80; //(!isset($_GET['q'])) ? 80 : $_GET['q'];;
		//$phpThumb->config_imagemagick_path = 'C:\Program Files\ImageMagick-6.3.6-Q16';
		$phpThumb->config_prefer_imagemagick = false;
		$phpThumb->config_output_format = 'jpg';
		$phpThumb->config_error_die_on_error = true;
		$phpThumb->config_temp_directory = TMP;
		$phpThumb->config_cache_directory = CACHE.'thumbs'.DS;
		$phpThumb->config_cache_disable_warning = true;
		$phpThumb->config_document_root = APP_PATH;
		$phpThumb->config_allow_src_above_docroot = true;
		$phpThumb->config_allow_src_above_phpthumb = true;
		//$phpThumb->phpThumbDebug = true;
			
		$cacheFilename = md5($key);
		
		$phpThumb->cache_filename = $phpThumb->config_cache_directory . $cacheFilename . '.jpg';

		if(!is_file($phpThumb->cache_filename)){ // Check if image is already cached.
			if($phpThumb->GenerateThumbnail()) {
				$phpThumb->RenderToFile($phpThumb->cache_filename);
		    } else {
		        die('Failed: '.$phpThumb->error);
		    }
		}

		$imageinfo = $phpThumb->getimagesizeinfo;
		App::import('Model','CourseImage');
		$this->CourseImage = new CourseImage;
		
		$courseImage = $this->CourseImage->find('first',array(
			'conditions' => array('CourseImage.course_id' => $this->viewVars['course']['id'],'CourseImage.filename' => basename($key))
		));
		if(!empty($courseImage)) {
			$this->CourseImage->id = $courseImage['CourseImage']['id'];
		}
		$this->CourseImage->save(array('CourseImage' => array(
			'course_id' => $this->viewVars['course']['id'],
			'filename' => basename($key),
			'width' => $imageinfo[0],
			'height' => $imageinfo[1]
		)));
		
		$s3->putObjectFile($phpThumb->cache_filename, $this->viewVars['bucket'], 'courses/' . $this->viewVars['course']['id'] . '/__thumbs/' . $cacheFilename . '.jpg', $this->viewVars['course']['open'] ? S3::ACL_PUBLIC_READ : S3::ACL_PRIVATE);
		unlink($phpThumb->cache_filename);
		if(!empty($S3Source))
			unlink($S3Source);
	}


	function index() {
		App::import('Vendor','s3');
		
		if(!empty($this->params['url']['bucket']) && !empty($this->params['url']['key'])) {
			$path_parts = pathinfo($this->params['url']['key']);
			$path_parts['extension'] = strtolower($path_parts['extension']);
			
			if($path_parts['extension'] == 'jpg' || $path_parts['extension'] == 'gif' || $path_parts['extension'] == 'png' || $path_parts['extension'] == 'jpeg') {
				$this->redirect('/' . $this->viewVars['group']['web_path'] . '/' . $this->viewVars['course']['web_path'] . '/files/create_thumbnail/' . basename($this->params['url']['key']));
				exit;				
			}
		} else if(!empty($this->params['file'])) {
			$this->file($this->params['file']);
			exit;
		}
		
		$s3 = new S3($this->viewVars['accessKey'], $this->viewVars['secretKey']);
		$files = $s3->getBucket($this->viewVars['bucket'],'courses/' . $this->viewVars['course']['id'] . '/',null,null,'/'); //, $prefix = null, $marker = null, $maxKeys = null
		
		$total_size = 0;
		foreach($files as &$file) {
			$total_size += $file['size'];
			$file['uri'] = '/' . $this->viewVars['group']['web_path'] . '/' .$this->viewVars['course']['web_path'] . '/files/' . basename($file['name']);
			$file['size'] = $this->get_file_size($file['size']);
		}
		
		$this->set(compact('files'));
		$this->set('total_size',$this->get_file_size($total_size));
		/*
		die;

		
		$directory = ROOT . DS . APP_DIR . DS . 'files' . DS . 'courses' . DS . $this->viewVars['course']['id'];
		if(!file_exists($directory))
			mkdir($directory);

		App::import('Vendor', 'mimetypehandler'.DS.'mimetypehandler');
		$mime = new MimetypeHandler();

		$total_size = 0;

		$files = array();
		if ($handle = opendir($directory)) {
		    while (false !== ($file = readdir($handle))) {
		        if(is_dir($directory . DS . $file))
		        	continue;

		        if ($file != "." && $file != "..") {
		            $size = filesize($directory . DS . $file);
					
					$files[strtolower($file)] = array(
		            	'basename' => $file,
		            	'type' => $mime->getMimetype($directory . DS . $file),
		            	'uri' => '/' . $this->viewVars['group']['web_path'] . '/' .$this->viewVars['course']['web_path'] . '/files/' . $file,
						'size' => $this->get_file_size($size)
		            );
					$total_size += $size;
		        }
		    }
		    closedir($handle);
		}
		ksort($files);

		$this->set(compact('files'));
		$this->set('total_size',$this->get_file_size($total_size));
		*/
		
		$this->set('title',__('Media Files',true) . ' &raquo; ' . $this->viewVars['course']['title'] . ' &raquo; ' . $this->viewVars['group']['name']);
		$this->Notifications->add(
			__('You need to install the latest version of <a href="http://www.adobe.com/products/flashplayer/">Adobe Flash Player</a>.',true),
			'error',
			'gclms-hidden gclms-upgrade-flash'
			);
	}
	
	function migrate_to_s3() {
		App::import('Vendor','s3');
		$s3 = new S3($this->viewVars['accessKey'], $this->viewVars['secretKey']);
		
		$directory = ROOT . DS . APP_DIR . DS . 'files' . DS . 'courses' . DS . $this->viewVars['course']['id'];
		
		if(!file_exists($directory))
			$this->redirect('/' . $this->viewVars['group']['web_path'] . '/' . $this->viewVars['course']['web_path'] . '/files');
			
		$files = scandir_excluding_dirs($directory);
		
		if(empty($files)){
			unlink($directory);
			$this->redirect('/' . $this->viewVars['group']['web_path'] . '/' . $this->viewVars['course']['web_path'] . '/files');				
		}
		
		$file = $files[0];
		
		set_time_limit(180);			
        $s3->putObjectFile($directory . DS . $file, $this->viewVars['bucket'], 'courses/' . $this->viewVars['course']['id'] . '/' . $file, $this->viewVars['course']['open'] ? S3::ACL_PUBLIC_READ : ACL_PRIVATE);
		set_time_limit(60);

        $path_parts = pathinfo($file);
		$path_parts['extension'] = strtolower($path_parts['extension']);
		if(in_array($path_parts['extension'],array('jpg','gif','png','jpeg'))) {
			$this->__create_thumbnail($file,$directory . DS . $file);
		}
		unlink($directory . DS . $file);
		
		$this->set(compact('file'));
	}
	
	function delete() {
		$this->RequestHandler->setContent('json', 'text/x-json');
		$directory = ROOT . DS . APP_DIR . DS . 'files' . DS . 'courses' . DS . $this->viewVars['course']['id'];
		$files = explode(',',$this->data['files']);
		foreach($files as $file) {
			unlink($directory . DS . basename($file));
		}
		$this->RequestHandler->setContent('json', 'text/x-json');
		$this->data = $files;
	}

	function afterSave() {
		$this->redirect = array('group'=>$this->viewVars['group']['web_path'],'action'=>'','controller' => null,'course'=>$this->viewVars['course']['web_path'],'lesson'=>$this->viewVars['lesson']['order']);
		parent::afterSave();
	}

	function media() {
		App::import('Vendor','s3');
		
		$s3 = new S3($this->viewVars['accessKey'], $this->viewVars['secretKey']);
		$files = $s3->getBucket($this->viewVars['bucket'],'courses/' . $this->viewVars['course']['id'] . '/',null,null,'/'); //, $prefix = null, $marker = null, $maxKeys = null
		
		$media_files = array();
		foreach($files as &$file) {
	        $path_parts = pathinfo($file['name']);
			$path_parts['extension'] = strtolower($path_parts['extension']);
			if(in_array($path_parts['extension'],array('swf','mp4','mov','flv'))) {
				$basename = basename($file['name']);
				$media_files[$basename] = array(
					'basename' => $basename,
					'uri' => '../../files/' . $basename,
					'size' => $this->get_file_size($file['size'])
				);
			}
		}
		
		ksort($media_files);

		$this->set('files',$media_files);
		$this->render('media','tinymce_popup');
	}

	function images() {
		App::import('Vendor','s3');
		
		$s3 = new S3($this->viewVars['accessKey'], $this->viewVars['secretKey']);
		$files = $s3->getBucket($this->viewVars['bucket'],'courses/' . $this->viewVars['course']['id'] . '/',null,null,'/'); //, $prefix = null, $marker = null, $maxKeys = null
		
		App::import('Model','CourseImage');
		$this->CourseImage = new CourseImage;
		$course_images = $this->CourseImage->find('all',array(
			'conditions' => array('CourseImage.course_id' => $this->viewVars['course']['id']),
			'fields' => array('filename','width','height')
		));
		$course_images = array_combine(
			Set::extract($course_images, '{n}.CourseImage.filename'),
			Set::extract($course_images, '{n}.CourseImage')
		);
		
		$images = array();
		foreach($files as &$file) {
	        $path_parts = pathinfo($file['name']);
			$path_parts['extension'] = strtolower($path_parts['extension']);
			if(in_array($path_parts['extension'],array('png','gif','jpg'))) {
				$basename = basename($file['name']);
				//prd(getimagesize('http://' . $this->viewVars['bucket'] . '.s3.amazonaws.com/courses/' . $this->viewVars['course']['id'] . '/' . $basename));
				$images[$basename] = array(
					'basename' => $basename,
					'uri' => '../../files/' . $basename,
					'size' => $this->get_file_size($file['size']),
					'width' => $course_images[basename($file['name'])]['width'],
					'height' => $course_images[basename($file['name'])]['height']
				);
			}
		}
		
		ksort($images);

		$this->set(compact('images'));
		$this->render('images','tinymce_popup');
	}
	
	function thumbnail($image) {
		$file = 'courses/' . $this->viewVars['course']['id'] . '/' . $image;
		$this->redirect($this->getS3Redirect('courses/' . $this->viewVars['course']['id'] . '/__thumbs/' . md5($file) . '.jpg'));
		//$this->redirect('http://' . $this->viewVars['bucket'] . '.s3.amazonaws.com/courses/' . $this->viewVars['course']['id'] . '/__thumbs/' . md5($file) . '.jpg');
	}

	function getS3Redirect($objectName) {
		$objectName = '/' . $objectName;
		$S3_URL = 'http://' . $this->viewVars['bucket'] . '.s3.amazonaws.com';
		$expires = strtotime(date('Y-m-d',strtotime('+1 day')));
		$bucketName = '/' . $this->viewVars['bucket'];
		
		$stringToSign = "GET\n\n\n$expires\n$bucketName$objectName";

		$signature = urlencode(base64_encode(hash_hmac('sha1', $stringToSign, $this->viewVars['secretKey'], TRUE)));
		
		return "$S3_URL$objectName?AWSAccessKeyId=" . $this->viewVars['accessKey'] . "&Expires=$expires&Signature=$signature";
	}

	function file() {
		if($this->viewVars['course']['open'])
			$file = 'http://' . $this->viewVars['bucket'] . '.s3.amazonaws.com/courses/' . $this->viewVars['course']['id'] . '/' . basename($this->params['url']['url']);
		else 
			$file = $this->getS3Redirect('courses/' . $this->viewVars['course']['id'] . '/' . basename($this->params['url']['url']));
		$this->redirect($file);
		exit;
		/*
		$path_parts = pathinfo($this->params['url']['url']);
		$file = low($path_parts['basename']);
		
		$file = ROOT . DS . APP_DIR . DS . 'files' . DS . 'courses' . DS . $this->viewVars['course']['id'] . DS . $file;

		if (!file_exists($file)) {
			die(__('File not found',true));
			exit;
		}

		$path_parts = pathinfo($file);
		$basename = $path_parts['basename'];

		App::import('Vendor','mimetypehandler'.DS.'mimetypehandler');
		$mime = new MimetypeHandler();
		$content_type = $mime->getMimetype($file);

	
		if(eregi('image',$content_type) === false && eregi('text',$content_type) === false) {
			header('Content-Disposition: attachment; filename="' . $basename . '"');
		} else {
			header('Content-Disposition: inline; filename="' . $basename . '"');
		}

		header('Content-type: ' . $content_type);
		header('Last-Modified: '.date('D, d M Y H:i:s', filemtime($file)).' GMT');
		//header('Expires: '.date('D, d M Y H:i:s', strtotime('+1 day')) . ' GMT');
		header('Content-length: ' . filesize($file));
		readfile($file);
		exit;
		*/
	}

	function logo() {
		if(!empty($this->viewVars['group']['logo']))
			$file = ROOT . DS . APP_DIR . DS . 'files' . DS . 'logos' . DS . $this->viewVars['group']['id'] . '.img';

		if (!isset($file) || !file_exists($file))
			$file = ROOT . DS . APP_DIR . DS . WEBROOT_DIR . DS . 'img' . DS .'ibs' . DS . 'logo.png';

		$imageInfo = getimagesize($file);
		$path_parts = pathinfo($file);

		header('Content-type: image/' . $imageInfo['mime']);
		header('Content-Disposition: inline; filename="' . $this->viewVars['group']['logo'] . '"');
		header('Last-Modified: '.date('D, d M Y H:i:s', filemtime($file)).' GMT');
		header('Expires: Thu, 15 Apr 2010 20:00:00 GMT');
		header('Content-length: ' . filesize($file));
		readfile($file);
		exit;
	}
	
	function css() {
		$this->course_css();
	}

	function group_css() {
		header('Content-type: text/css');
		header('Content-length: ' . strlen($this->viewVars['group']['css']));
    	header("Cache-Control: public");
    	header("Cache-Control: maxage=604800");
		//header('Expires: Thu, 15 Apr 2010 20:00:00 GMT');
		//header('Last-Modified: '.date('D, d M Y H:i:s', filemtime($file)).' GMT');
		echo $this->viewVars['group']['css'];
		exit;
	}

	function course_css() {
		header('Content-type: text/css');
		header('Content-length: ' . strlen($this->viewVars['course']['css']));
    	header("Cache-Control: public");
    	header("Cache-Control: maxage=604800");
		//header('Expires: Thu, 15 Apr 2010 20:00:00 GMT');
		//header('Last-Modified: '.date('D, d M Y H:i:s', filemtime($file)).' GMT');
		//echo '@import url("/css/page.css");';
		echo $this->viewVars['course']['css'];
		exit;
	}
}