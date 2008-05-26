<?
class FilesController extends AppController {
    var $uses = array('User','Group','Course');
	var $components = array('Notifications','RequestHandler');

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

	function index() {
		if(!empty($this->params['file'])) {
			$this->file($this->params['file']);
			die;
		}
		
		$directory = ROOT . DS . APP_DIR . DS . 'files' . DS . 'courses' . DS . $this->viewVars['course']['id'];
		if(!file_exists($directory))
			mkdir($directory);

		App::import('Vendor', 'mimetypehandler'.DS.'mimetypehandler');
		$mime = new MimetypeHandler();

		$files = array();
		if ($handle = opendir($directory)) {
		    while (false !== ($file = readdir($handle))) {
		        if(is_dir($directory . DS . $file))
		        	continue;

		        if ($file != "." && $file != "..") {
		            $files[strtolower($file)] = array(
		            	'basename' => $file,
		            	'type' => $mime->getMimetype($directory . DS . $file),
		            	'uri' => '/' . $this->viewVars['group']['web_path'] . '/' .$this->viewVars['course']['web_path'] . '/files/' . $file,
						'size' => $this->get_file_size(filesize($directory . DS . $file))
		            );
		        }
		    }
		    closedir($handle);
		}
		ksort($files);

		$this->set(compact('files'));
		
		$this->set('title',__('Media Files',true) . ' &raquo; ' . $this->viewVars['course']['title'] . ' &raquo; ' . $this->viewVars['group']['name']);
		$this->Notifications->add(
			__('You need to install the latest version of <a href="http://www.adobe.com/products/flashplayer/">Adobe Flash Player</a>.',true),
			'error',
			'gclms-hidden gclms-upgrade-flash'
			);
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
		if(isset($this->passedArgs[1])) {
			$this->file($this->passedArgs[1]);
			die();
		}

		$directory = ROOT . DS . APP_DIR . DS . 'files' . DS . 'courses' . DS . $this->viewVars['course']['id'];
		if(!file_exists($directory))
			mkdir($directory);

		App::import('Vendor', 'mimetypehandler'.DS.'mimetypehandler');
		$mime = new MimetypeHandler();

		$files = array();
		if ($handle = opendir($directory)) {
		    while (false !== ($file = readdir($handle))) {
		        if(is_dir($directory . DS . $file))
		        	continue;

		        $fileinfo = pathinfo($file);

		        if ($file != "." && $file != ".." && in_array($fileinfo['extension'],array('swf','mp4','mov'))) {
		            $files[strtolower($file)] = array(
		            	'basename' => $file,
		            	'type' => $mime->getMimetype($directory . DS . $file),
		            	'uri' => '/' . $this->viewVars['group']['web_path'] . '/' . $this->viewVars['course']['web_path'] . '/files/' . $file
		            );
		        }
		    }
		    closedir($handle);
		}
		ksort($files);

		$this->set(compact('files'));

		$this->render('media','tinymce_popup');
	}

	function images() {
		if(isset($this->passedArgs[1])) {
			$this->file($this->passedArgs[1]);
			die();
		}

		$directory = ROOT . DS . APP_DIR . DS . 'files' . DS . 'courses' . DS . $this->viewVars['course']['id'];
		if(!file_exists($directory))
			mkdir($directory);

		App::import('Vendor', 'mimetypehandler'.DS.'mimetypehandler');
		$mime = new MimetypeHandler();

		$files = array();
		if ($handle = opendir($directory)) {
		    while (false !== ($file = readdir($handle))) {
		        $fileinfo = pathinfo($file);
		        if ($file != "." && $file != ".." && in_array($fileinfo['extension'],array('png','gif','jpg'))) {
					$imageSize = getimagesize($directory . DS . $file);
		            $files[strtolower($file)] = array(
		            	'basename' => $file,
		            	'type' => $mime->getMimetype($directory . DS . $file),
		            	'uri' => '/' . $this->viewVars['group']['web_path'] . '/' . $this->viewVars['course']['web_path'] . '/files/' . $file,
						'width' => $imageSize[0],
						'height' => $imageSize[1]
		            );
		        }
		    }
		    closedir($handle);
		}
		ksort($files);

		$this->set(compact('files'));

		$this->render('images','tinymce_popup');
	}
	
	function thumbnail($image) {
		$file = $image;
		
		$file = ROOT . DS . APP_DIR . DS . 'files' . DS . 'courses' . DS . $this->viewVars['course']['id'] . DS . $file;

		if (!file_exists($file)) {
			exit;
		}

		$width = (!isset($_GET['w'])) ? 100 : $_GET['w'];
		$height = (!isset($_GET['h'])) ? 100 : $_GET['h'];
		$quality = (!isset($_GET['q'])) ? 85 : $_GET['q'];
		
		$sourceFilename = $file;

		if(is_readable($sourceFilename)){
			App::import('Vendor','phpthumb' . DS . 'phpthumbclass');
			$phpThumb = new phpThumb();

			$phpThumb->src = $sourceFilename;
			$phpThumb->w = $width;
			$phpThumb->h = $height;
			$phpThumb->q = $quality;
			//$phpThumb->config_imagemagick_path = 'C:\Program Files\ImageMagick-6.3.6-Q16';
			$phpThumb->config_prefer_imagemagick = false;
			$phpThumb->config_output_format = 'jpg';
			$phpThumb->config_error_die_on_error = true;
			$phpThumb->config_allow_src_above_docroot = true;
			$phpThumb->config_allow_src_above_phpthumb = true;
			$phpThumb->config_document_root = '';
			$phpThumb->config_temp_directory = APP . 'tmp';
			$phpThumb->config_cache_directory = CACHE.'thumbs'.DS;
			$phpThumb->config_cache_disable_warning = true;

			$cacheFilename = md5($_SERVER['REQUEST_URI']);
			
			$phpThumb->cache_filename = $phpThumb->config_cache_directory.$cacheFilename;

			//Thanks to Kim Biesbjerg for his fix about cached thumbnails being regeneratd
			if(!is_file($phpThumb->cache_filename)){ // Check if image is already cached.
				if ($phpThumb->GenerateThumbnail()) {
			        $phpThumb->RenderToFile($phpThumb->cache_filename);
			    } else {
			        die('Failed: '.$phpThumb->error);
			    }
			}
            
            if(is_file($phpThumb->cache_filename)){ // If thumb was already generated we want to use cached version
				$cachedImage = getimagesize($phpThumb->cache_filename);
				header('Content-Type: '.$cachedImage['mime']);
				readfile($phpThumb->cache_filename);
				exit;
			}
		} else { // Can't read source
			die("Couldn't read source image ".$sourceFilename);
		}
	}

	function file() {
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
	}

	function logo() {
		if(!empty($this->viewVars['group']['logo']))
			$file = ROOT . DS . APP_DIR . DS . 'files' . DS . 'logos' . DS . $this->viewVars['group']['id'] . '.img';

		if (!isset($file) || !file_exists($file))
			$file = ROOT . DS . APP_DIR . DS . WEBROOT_DIR . DS . 'img' . DS .'ibs' . DS . 'logo.png';

		$imageInfo = getimagesize($file);
		$fileInfo = pathinfo($file);

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