<?php
/*
 * Asset Packer CakePHP Component
 * Copyright (c) 2007 Matt Curry
 * www.PseudoCoder.com
 *
 * @author      mattc <matt@pseudocoder.com>
 * @version     1.0
 * @license     MIT
 *
 */

class AssetHelper extends Helper {
    //there is a  *minimal* perfomance hit associated with looking up the filemtimes
    //if you clean out your cached dir (as set below) on builds then you don't need this.
    var $checkTS = true;

    var $helpers = array('Html', 'Javascript');
    var $viewScriptCount = 0;

    //you can change this if you want to store the files in a different location
    var $cachePath = 'packed/';

    //set the css compression level
    //options: default, low_compression, high_compression, highest_compression
    //default is no compression
    //I like high_compression because it still leaves the file readable.
    var $cssCompression = 'high_compression';

    //flag so we know the view is done rendering and it's the layouts turn
    function afterRender() {
        $view =& ClassRegistry::getObject('view');
        $this->viewScriptCount = count($view->__scripts);
    }

	function css_for_layout($offline = false) {
        $view =& ClassRegistry::getObject('view');

        //nothing to do
        if (!$view->__scripts) {
			return;
        }

        //move the layout scripts to the front
        $view->__scripts = array_merge(
                               array_slice($view->__scripts, $this->viewScriptCount),
                               array_slice($view->__scripts, 0, $this->viewScriptCount)
                           );


		// Relative links when offline
		if($offline) {
			$path = parse_url($view->here);
			$depth = substr_count($path['path'],'/');
			$relative_path = str_repeat('../',$depth - 1);

			foreach($view->__scripts as &$script) {
				if(strstr($script,'.css') && !strstr($script,'/files')) {
					$script = str_replace('href="/css','href="' . $relative_path . 'css',$script);
				}
				//$script
			}
		}
		
        if(1 || Configure::read('debug')) {
            $css = array();
			foreach($view->__scripts as $script) {
				if(strstr($script,'.css'))
					$css[] = $script;
			}

			return join("\n\t", $css);
        }

        //only css scripts
        foreach ($view->__scripts as $i => $script) {
            if (preg_match('/css\/(.*).css/', $script, $match)) {
                $temp = array();
                $temp['script'] = $match[1];
                $temp['name'] = basename($match[1]);
                $css[] = $temp;

                //remove the script since it will become part of the merged script
                unset($view->__scripts[$i]);
            }
        }

        $style_for_layout = '';
        if (!empty($css)) {
	    	$style_for_layout .= $this->Html->css($this->cachePath . $this->process('css', $css));
		}
        $style_for_layout .= "\n\t";

        return $style_for_layout;
	}
	
	function js_for_layout() {
		$view =& ClassRegistry::getObject('view');

        //nothing to do
        if (!$view->__scripts) {
			return;
        }

        //move the layout scripts to the front
        /*
		$view->__scripts = array_merge(
                               array_slice($view->__scripts, $this->viewScriptCount),
                               array_slice($view->__scripts, 0, $this->viewScriptCount)
                           );
		*/

        if(1 || Configure::read('debug')) {
            $js = array();
			foreach($view->__scripts as $script) {
				if(strstr($script,'.js')) {
					if(strpos($script,'prototype.js') !== false) {
						//$script = '<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/prototype/1.6.0.2/prototype.js"></script>';
					}	
					$js[] = $script;
				}
			}
			return join("\n\t", $js);
        }

        //only js scripts
        foreach ($view->__scripts as $i => $script) {
            if (preg_match('/js\/(.*).js/', $script, $match)) {
                pr($match);die;
				$temp = array();
                $temp['script'] = $match[1];
                $temp['name'] = basename($match[1]);
                $js[] = $temp;

                //remove the script since it will become part of the merged script
                unset($view->__scripts[$i]);
            }
        }

        $style_for_layout = '';

        if (!empty($js)) {
			$style_for_layout .= $this->Javascript->link($this->cachePath . $this->process('js', $js));
        }

        return $style_for_layout;
	}

    function process($type, $data) {
        switch($type) {
            case 'js':
                    $path = JS;
                break;
            case 'css':
                $path = CSS;
                break;
        }

        $folder = new Folder;

        //make sure the cache folder exists
        $folder->mkdirr($path . $this->cachePath);

        //check if the cached file exists
        $names = Set::extract($data, '{n}.name');

        $folder->cd($path . $this->cachePath);
        $fileName = $folder->find('all' . '_([0-9]{10}).' . $type);

        if ($fileName) {
            //take the first file...really should only be one.
            $fileName = $fileName[0];
        }

        //make sure all the pieces that went into the packed script
        //are OLDER then the packed version
        if($this->checkTS && $fileName) {
			$packed_ts = filemtime($path . $this->cachePath . $fileName);

            $latest_ts = 0;
            $scripts = Set::extract($data, '{n}.script');
            foreach($scripts as $script) {
                $latest_ts = max($latest_ts, filemtime($path . $script . '.' . $type));
            }

            //an original file is newer.  need to rebuild
            if ($latest_ts > $packed_ts) {
                unlink($path . $this->cachePath . $fileName);
                $fileName = null;
            }
        }

        //file doesn't exist.  create it.
        if (!$fileName) {
            $ts = time();

            //merge the script
            $scriptBuffer = '';
            $scripts = Set::extract($data, '{n}.script');
            foreach($scripts as $script) {
                $scriptBuffer .= file_get_contents($path . $script . '.' . $type);
            }

            switch($type) {
                case 'js':
                    //jsmin only works with PHP5
                    if (PHP5) {
						App::import('Vendor','jsmin' . DS . 'jsmin');
                        $scriptBuffer = JSMin::minify($scriptBuffer);
                    }
                    break;

                case 'css':
					App::import('Vendor','csstidy' . DS . 'class.csstidy');
                    $tidy = new csstidy();
                    $tidy->load_template($this->cssCompression);
                    $tidy->parse($scriptBuffer);
                    $scriptBuffer = $tidy->print->plain();
                    break;

            }


            //write the file
            //$fileName = implode('_', $names) . '_' . $ts . '.' . $type;
			//$fileName = hash('ripemd160',implode('_', $names)) . '_' . $ts . '.' . $type;
			$fileName = 'all_' . $ts . '.' . $type;
            $file = new File($path . $this->cachePath . $fileName);
            $file->write(trim($scriptBuffer));
        }

        if ($type == 'css') {
            //$html->css doesn't check if the file already has
            //the .css extension and adds it automatically, so we need to remove it.
            $fileName = str_replace('.css', '', $fileName);
        }

        return $fileName;
    }
}
