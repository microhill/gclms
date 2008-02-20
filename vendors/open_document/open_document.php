<?
DEFINE('DEBUG',false);

class OpenDocument {
	/**
     * Path to opened OpenDocument file
     *
     * @var string
     * @access private
     */
    private $path;
    
    /**
     * DOMNode of current node
     *
     * @var DOMNode
     * @access provate
     */
    private $cursor;
    
    /**
     * DOMNode contains style information
     *
     * @var DOMNode
     * @access private
     */
    private $styles;
    
    /**
     * DOMNode contains fonts declarations
     *
     * @var DOMNode
     * @access private
     */
    private $fonts;
    
    /**
     * Mime type information
     *
     * @var string
     * @access private
     */
    private $mimetype;
    
    /**
     * Flag indicates whether it is a new file
     *
     * @var bool
     * @access private
     */
    private $create = false;

    /**
     * DOMDocument for content file
     *
     * @var DOMDocument
     * @access private
     */
    private $contentDOM;

    /**
     * DOMXPath object for content file
     *
     * @var DOMXPath
     * @access private
     */
    private $contentXPath;

    /**
     * DOMDocument for meta file
     *
     * @var DOMDocument
     * @access private
     */
    private $metaDOM;

    /**
     * DOMXPath for meta file
     *
     * @var DOMXPath
     * @access private
     */
    private $metaXPath;

    /**
     * DOMDocument for settings file
     *
     * @var DOMDocument
     * @access private
     */
    private $settingsDOM;

    /**
     * DOMXPath for setting file
     *
     * @var DOMXPath
     * @access private
     */
    private $settingsXPath;

    /**
     * DOMDocument for styles file
     *
     * @var DOMDocument
     * @access private
     */
    private $stylesDOM;

    /**
     * DOMXPath for styles file
     *
     * @var DOMXPath
     * @access private
     */
    private $stylesXPath;

    /**
     * DOMDocument for styles file
     *
     * @var DOMDocument
     * @access private
     */
    private $manifestDOM;

    /**
     * DOMXPath for manifest file
     *
     * @var DOMXPath
     * @access private
     */
    private $manifestXPath;
            
    /**
     * Collection of children objects
     *
     * @var ArrayIterator
     * @access read-only
     */
    private $children;

    /**
     * File with document contents
     */
    const FILE_CONTENT = 'content.xml';
    
    /**
     * File with meta information
     */
    const FILE_META = 'meta.xml';
    
    /**
     * File with editor settings
     */
    const FILE_SETTINGS = 'settings.xml';
    
    /**
     * File with document styles
     */
    const FILE_STYLES = 'styles.xml';
    
    /**
     * File with mime type
     */
    const FILE_MIMETYPE = 'mimetype';
    
    /**
     * File with manifest information
     */
    const FILE_MANIFEST = 'META-INF/manifest.xml';

    /**
     * text namespace URL
     */
    const NS_TEXT = 'urn:oasis:names:tc:opendocument:xmlns:text:1.0';
	
    /**
     * table namespace URL
     */
    const NS_TABLE = 'urn:oasis:names:tc:opendocument:xmlns:table:1.0';
    
    /**
     * style namespace URL
     */
    const NS_STYLE = 'urn:oasis:names:tc:opendocument:xmlns:style:1.0';
    
    /**
     * fo namespace URL
     */
    const NS_FO = 'urn:oasis:names:tc:opendocument:xmlns:xsl-fo-compatible:1.0';
    
    /**
     * office namespace URL
     */
    const NS_OFFICE = 'urn:oasis:names:tc:opendocument:xmlns:office:1.0';
    
    /**
     * svg namespace URL
     */
    const NS_SVG = 'urn:oasis:names:tc:opendocument:xmlns:svg-compatible:1.0';
    
    /**
     * xlink namespace URL
     */
    const NS_XLINK = 'http://www.w3.org/1999/xlink';

   /**
     * Constructor
     *
     * @param string $filename optional
     *               specify file name if you want to open existing file
     *               to create new document pass nothing or empty string
     * @throws OpenDocument_Exception
     */
    public function __construct($filename = '') {
        if (!strlen($filename)) {
            $filename = dirname(__FILE__) . DS . 'template.odt';
            $this->create = true;
        }

        if (!is_readable($filename)) {
            die('File not readable');
        }
        $this->path = $filename;

        //get mimetype
        if (!$this->mimetype = $this->ZipRead($filename, self::FILE_MIMETYPE))
			die('Different mimetype');

        //get content
        $this->contentDOM = new DOMDocument;
        $this->contentDOM->loadXML($this->ZipRead($filename, self::FILE_CONTENT));
        $this->contentXPath = new DOMXPath($this->contentDOM);

        //get meta data
        $this->metaDOM = new DOMDocument();
        $this->metaDOM->loadXML($this->ZipRead($filename, self::FILE_META));
        $this->metaXPath = new DOMXPath($this->metaDOM);

        //get settings
        $this->settingsDOM = new DOMDocument();
        $this->settingsDOM->loadXML($this->ZipRead($filename, self::FILE_SETTINGS));
        $this->settingsXPath = new DOMXPath($this->settingsDOM);

        //get styles
        $this->stylesDOM = new DOMDocument();
        $this->stylesDOM->loadXML($this->ZipRead($filename, self::FILE_STYLES));
        $this->stylesXPath = new DOMXPath($this->stylesDOM);

        //get manifest information
        $this->manifestDOM = new DOMDocument();
        $this->manifestDOM->loadXML($this->ZipRead($filename, self::FILE_MANIFEST));
        $this->manifestXPath = new DOMXPath($this->manifestDOM);
        
        //set cursor
        $this->cursor = $this->contentXPath->query('/office:document-content/office:body/office:text')->item(0);
		$this->styles = $this->contentXPath->query('/office:document-content/office:automatic-styles')->item(0);
    	$this->fonts  = $this->contentXPath->query('/office:document-content/office:font-face-decls')->item(0);
    	$this->contentXPath->registerNamespace('text', self::NS_TEXT);
    }
	
	function importHTML($HTML) {
		$this->HTMLDOM = new DOMDocument;
		$this->HTMLDOM->loadHTML($HTML);
		
		$this->importHTMLNode($this->HTMLDOM->getElementsByTagName('body')->item(0), &$this->cursor);
		$this->contentDOM->saveXML();
	}
	
	function importHTMLFile($file) {
		//echo($this->contentDOM->saveXML());
		$this->importHTML(file_get_contents($file));
		
		//echo '<pre>';

	}
	
	function appendHeading(&$node,$level,$styles = null) {
		$element = $node->ownerDocument->createElementNS(OpenDocument::NS_TEXT, 'h');
		$element->setAttributeNS(OpenDocument::NS_TEXT,'outline-level',$level);
        $element = $node->appendChild($element);
		
		return $element;
	}
	
	function appendParagraph(&$node,$styles = null) {
		$element = $node->ownerDocument->createElementNS(OpenDocument::NS_TEXT, 'p');
        $element = $node->appendChild($element);
		
		return $element;
	}
	
	function applyStyles(&$node,$family,$styles = null) {
		if(!$styles)
			return false;
		
		$id = uniqid();
			
		$styleElement = $node->ownerDocument->createElementNS(OpenDocument::NS_STYLE, 'style');
		$styleElement->setAttributeNS(OpenDocument::NS_STYLE,'family',$family);
		$styleElement->setAttributeNS(OpenDocument::NS_STYLE,'name',$id);
		$this->styles->appendChild($styleElement);
		
		$textPropertiesElement = $node->ownerDocument->createElementNS(OpenDocument::NS_STYLE, 'text-properties');
		$styleElement->appendChild($textPropertiesElement);
		
		foreach($styles as $styleName => $value) {
			$textPropertiesElement->setAttributeNS(OpenDocument::NS_FO,$styleName,$value);
		}
		
		$node->setAttributeNS(OpenDocument::NS_TEXT,'style-name',$id);
	}
	
	function appendSpan(&$node,$styles = null) {
		$element = $node->ownerDocument->createElementNS(OpenDocument::NS_TEXT, 'span');
        $element = $node->appendChild($element);		
		
		self::applyStyles($element,'text',$styles);
		
		return $element;
	}
	
	function appendTextElement(&$node,$text) {
		$element = $node->ownerDocument->createTextNode($text);
        $element = $node->appendChild($element);		
		
		return $element;
	}
	
	function appendList(&$node) {
		$element = $node->ownerDocument->createElementNS(OpenDocument::NS_TEXT, 'list');
        $element = $node->appendChild($element);		
		
		return $element;
	}
	
	function appendListItem(&$node) {
		$listElement = $node->ownerDocument->createElementNS(OpenDocument::NS_TEXT, 'list-item');
        $listElement = $node->appendChild($listElement);		
		
		$paragraphElement = $node->ownerDocument->createElementNS(OpenDocument::NS_TEXT, 'p');
		$paragraphElement = $listElement->appendChild($paragraphElement);	
		
		return $paragraphElement;
	}
	
	function appendTable(&$node) {
		$element = $node->ownerDocument->createElementNS(OpenDocument::NS_TABLE, 'table');
        $element = $node->appendChild($element);		
		
		return $element;
	}
	
	function appendTableRow(&$node) {
		$element = $node->ownerDocument->createElementNS(OpenDocument::NS_TABLE, 'table-row');
        $element = $node->appendChild($element);		
		
		return $element;
	}
	
	function appendTableCell(&$node) {
		$cellElement = $node->ownerDocument->createElementNS(OpenDocument::NS_TABLE, 'table-cell');
        $cellElement = $node->appendChild($cellElement);		
		
		$paragraphElement = $node->ownerDocument->createElementNS(OpenDocument::NS_TEXT, 'p');
		$paragraphElement = $cellElement->appendChild($paragraphElement);	

		$tableColumn = $node->parentNode->getElementsByTagNameNS(OpenDocument::NS_TABLE,'table-column')->item(0);
		if($tableColumn) {
			$totalCellsInThisRow = $node->getElementsByTagNameNS(OpenDocument::NS_TABLE,'table-cell')->length;
			if($totalCellsInThisRow > $tableColumn->getAttributeNS(OpenDocument::NS_TABLE,'number-columns-repeated'))
				$tableColumn->setAttributeNS(OpenDocument::NS_TABLE,'number-columns-repeated',$totalCellsInThisRow);
		} else {
			$tableColumn = $node->ownerDocument->createElementNS(OpenDocument::NS_TABLE, 'table-column');
			$tableColumn = $node->parentNode->insertBefore($tableColumn,$node);
			$tableColumn->setAttributeNS(OpenDocument::NS_TABLE,'number-columns-repeated','1');
		}
		
		return $paragraphElement;
	}
	
	function appendHyperlink(&$node,$location,$styles = null) {
		$element = $node->ownerDocument->createElementNS(OpenDocument::NS_TEXT, 'a');
        $element = $node->appendChild($element);
		
		$element->setAttributeNS(OpenDocument::NS_XLINK,'type','simple');
		$element->setAttributeNS(OpenDocument::NS_XLINK,'href',$location);
		
		return $element;
	}

	function importHTMLNode(&$HTMLNode, &$ODTNode, $level = 1) {
		if($HTMLNode->nodeName == 'body') {
			foreach($HTMLNode->childNodes as $childNode) {
				if(DEBUG)
					echo '<ul>';
				$this->importHTMLNode(&$childNode, &$ODTNode, $level + 1);
				if(DEBUG)
					echo '</ul>';
			}
			return true;
		}

		if(DEBUG)
			echo '<li>' . $level . ' - ' . $HTMLNode->nodeName;

		switch($HTMLNode->nodeName) {
			case '#text':

				if(!method_exists($ODTNode,'createTextElement')) {
					//return false;
				}

				if(!empty($HTMLNode->nodeValue)) {
					$newOdtElement = $this->appendTextElement($ODTNode,
						ereg_replace("[\n\r]", '', $HTMLNode->nodeValue)
					);
				}
				break;
				
			case 'h1':
				$newODTNode = $this->appendHeading(&$ODTNode, 1);
				break;
			case 'h2':
				$newODTNode = $this->appendHeading(&$ODTNode, 2);
				break;
			case 'h3':
				$newODTNode = $this->appendHeading(&$ODTNode, 3);
				break;
			case 'h4':
				$newODTNode = $this->appendHeading(&$ODTNode, 4);
				break;
			case 'h5':
				$newODTNode = $this->appendHeading(&$ODTNode, 5);
				break;	
			case 'h6':
				$newODTNode = $this->appendHeading(&$ODTNode, 6);
				break;	
				
			case 'p':
				$newODTNode = $this->appendParagraph(&$ODTNode);
				break;
				
			case 'blockquote':
				$newODTNode = $this->appendParagraph(&$ODTNode);
				break;
				
			case 'strong':
			case 'b':			
				$newODTNode = $this->appendSpan(&$ODTNode, array(
					'font-weight' => 'bold'
				));
				//$newODTNode->style->fontWeight = 'bold';
				break;
				
			case 'em':
			case 'i':			
				$newODTNode = $this->appendSpan(&$ODTNode,array(
					'font-style' => 'italic'
				));
				//$newODTNode->style->fontStyle = 'italic';
				break;
				
			case 'u':			
				$newODTNode = $this->appendSpan(&$ODTNode,array(
					'text-underline-style' => 'solid',
					'text-underline-width' => 'auto',
					'text-underline-color' => 'font-color'
				));
				break;
				
			case 'span':			
				$newODTNode = $this->appendSpan(&$ODTNode);
				//$newODTNode->style->fontStyle = 'italic';
				break;
				
			case 'table':			
				$newODTNode = $this->appendTable(&$ODTNode);
				//$newODTNode->style->fontStyle = 'italic';
				break;
				
			case 'tbody':			
				$newODTNode = &$ODTNode;
				break;
				
			case 'tr':			
				$newODTNode = $this->appendTableRow(&$ODTNode);
				//$newODTNode->style->fontStyle = 'italic';
				break;
				
			case 'th':
			case 'td':			
				$newODTNode = $this->appendTableCell(&$ODTNode);
				//$newODTNode->style->fontStyle = 'italic';
				break;
				
			case 'ul':
			case 'ol':
				$newODTNode = $this->appendList(&$ODTNode);
				//$newODTNode->style->fontStyle = 'italic';
				break;
				
			case 'li':			
				$newODTNode = $this->appendListItem(&$ODTNode);
				//$newODTNode->style->fontStyle = 'italic';
				break;
				
			case 'a':
				$newODTNode = $this->appendHyperlink(&$ODTNode,$HTMLNode->getAttribute('href'));
				break;
				
			default:
				return true;
				break;
		}
		
		if(!$HTMLNode->hasChildNodes())
			return true;
			
		foreach($HTMLNode->childNodes as $childNode) {
			//echo $childNode->nodeName . "\n";
			if(DEBUG)
				echo '<ul>';
			$this->importHTMLNode($childNode, &$newODTNode, $level + 1);
			if(DEBUG)
				echo '</ul>';
		}
		if(DEBUG)
			echo '<li>';
	}
	
    public function save($filename = '') {
		if (strlen($filename)) {
            $this->path = $filename;
        }
        //write mimetype
        if (!$this->zipWrite($this->path, self::FILE_MIMETYPE, $this->mimetype)) {
            die('Error');
			throw new OpenDocument_Exception(OpenDocument_Exception::WRITE_MIMETYPE_ERR);
        }

        //write content
        $xml = str_replace("'", '&apos;', $this->contentDOM->saveXML());
        if (!$this->zipWrite($this->path, self::FILE_CONTENT, $xml)) {
            die('Error');
            throw new OpenDocument_Exception(OpenDocument_Exception::WRITE_CONTENT_ERR);
        }

        //write meta
        $xml = str_replace("'", '&apos;', $this->metaDOM->saveXML());
        if (!$this->zipWrite($this->path, self::FILE_META, $xml)) {
            die('Error');
            throw new OpenDocument_Exception(OpenDocument_Exception::WRITE_META_ERR);
        }

        //write settings
        $xml = str_replace("'", '&apos;', $this->settingsDOM->saveXML());
        if (!$this->zipWrite($this->path, self::FILE_SETTINGS, $xml)) {
            die('Error');
            throw new OpenDocument_Exception(OpenDocument_Exception::WRITE_SETTINGS_ERR);
        }

        //write styles
        $xml = str_replace("'", '&apos;', $this->stylesDOM->saveXML());
        if (!$this->zipWrite($this->path, self::FILE_STYLES, $xml)) {
            die('Error');
            throw new OpenDocument_Exception(OpenDocument_Exception::WRITE_STYLES_ERR);
        }

        //write manifest
        $xml = str_replace("'", '&apos;', $this->manifestDOM->saveXML());
        if (!$this->zipWrite($this->path, self::FILE_MANIFEST, $xml)) {
            die('Error');
            throw new OpenDocument_Exception(OpenDocument_Exception::WRITE_MANIFEST_ERR);
        }
    }
	
    /**
     * Get array of declared font names
     *
     * @return array
     */
    private function getFonts()
    {
        $nodes = $this->fonts->getElementsByTagNameNS(self::NS_STYLE, 'font-face');
        $fonts = array();
        foreach ($nodes as $node) {
            $fonts[] = $node->getAttributeNS(self::NS_STYLE, 'name');
        }
        return $fonts;
    }
	
    /**
     * Add new font declaration
     *
     * @param string $font_name
     * @param string $font_family optional
     */
    public function addFont($font_name, $font_family = '')
    {
        if (!in_array($font_name, $this->getFonts())) {
            $node = $this->contentDOM->createElementNS(self::NS_STYLE, 'font-face');
            $this->fonts->appendChild($node);
            $node->setAttributeNS(self::NS_STYLE, 'name', $font_name);
            if (!strlen($font_family)) {
                $font_family = $font_name;
            }
            $node->setAttributeNS(self::NS_SVG, 'font-family', $font_family);
        }
    }
	
    public static function zipRead($archive, $filename)
    {
        $zip = new ZipArchive;
        if (file_exists($archive)) {
            if ($zip->open(realpath($archive))) {
                if ($zip->locateName($filename) !== false) {
                    return $zip->getFromName($filename);
                }
            }
        }

        return false;
    }
    
    public static function zipWrite($archive, $filename, $content) {
		
		$zip = new ZipArchive;
        if (file_exists($archive)) {
            $zip->open(realpath($archive));
        } else {
            $zip->open(getcwd() . '/' .  $archive, ZipArchive::CREATE);
        }

        if ($zip->locateName($filename) !== false) {
            $zip->deleteName($filename);
        }
        $error = $zip->addFromString($filename, $content);

        return $error;
    }
}