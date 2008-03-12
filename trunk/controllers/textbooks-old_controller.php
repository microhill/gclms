<?php
class BooksController extends AppController {
    var $uses = array('Course');

	function beforeFilter() {
		parent::beforeFilter();
		//$this->Security->requireAuth('save');
		parent::beforeFilter();
	}

	function beforeRender() {
		$this->defaultBreadcrumbsAndLogo();
		$this->Breadcrumbs->addCrumb('Books','/' . $this->viewVars['group']['web_path'] . '/dictionary/course:' . $this->viewVars['course']['web_path']);
		parent::beforeRender();
	}

	function checkCourseFilesAndBooksDirectory() {
		$directory = ROOT . DS . APP_DIR . DS . 'files' . DS . 'courses' . DS . $this->viewVars['course']['id'];
		if(!file_exists($directory))
			mkdir($directory);

		$directory = ROOT . DS . APP_DIR . DS . 'files' . DS . 'courses' . DS . $this->viewVars['course']['id'] . DS . 'books';
		if(!file_exists($directory))
			mkdir($directory);

		return $directory;
	}

	function file() {
		$directory = $this->checkCourseFilesAndBooksDirectory();
		$file = $directory . DS . $this->passedArgs[0] . DS . $this->passedArgs[1];

		if (!file_exists($file)) {
			exit;
		}

		$path_parts = pathinfo($file);
		$basename = $path_parts['basename'];

		vendor('mimetypehandler'.DS.'mimetypehandler');
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
		exit();
	}

	function index() {
		if(isset($this->passedArgs[1])) {
			$this->file($this->passedArgs[1]);
			exit;
		}

		$directory = $this->checkCourseFilesAndBooksDirectory();

		$books = array();
		if ($handle = opendir($directory)) {
		    while (false !== ($file = readdir($handle))) {
		        if(!is_dir($directory . DS . $file) || $file == '.' || $file == '..')
		        	continue;

	            $books[strtolower($file)] = $file;
		    }
		    closedir($handle);
		}
		ksort($books);
		$this->set(compact('books'));
	}

	function add() {
		$booksDirectory = $this->checkCourseFilesAndBooksDirectory();

		$zip = zip_open($this->data['Book']['archive']['tmp_name']);
		if(!$zip || is_int($zip)) {
			die('That is not an archive file, dude. Aaron, change this error message to something more professional.');
		}

		$pathinfo = pathinfo($this->data['Book']['archive']['name']);
		$book_slug = Inflector::slug($pathinfo['filename']);

		if(!file_exists($booksDirectory . DS . $book_slug))
			mkdir($booksDirectory . DS . $book_slug);

	    while ($zip_entry = zip_read($zip)) {
		    $fp = fopen($booksDirectory . DS . $book_slug . DS . zip_entry_name($zip_entry), 'w');
		    if (zip_entry_open($zip, $zip_entry, 'r')) {
				$buf = zip_entry_read($zip_entry, zip_entry_filesize($zip_entry));
				fwrite($fp,$buf);
				zip_entry_close($zip_entry);
				fclose($fp);
		    }
	    }

	    zip_close($zip);

		$this->redirect('/' . $this->viewVars['group']['web_path'] . '/books/course:' . $this->viewVars['course']['web_path']);
	}

	function delete() {
	}

	function save($id = 0) {
		parent::save($id);
	}

	function afterSave() {
		$this->redirect('/' . $this->viewVars['group']['web_path'] . '/books/course:' . $this->viewVars['course']['web_path']);
	}
}