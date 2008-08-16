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
     * Text direction
     *
     * @var string
     * @access public
     */
    public $text_direction = 'lr-tb';
    
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
    var $create = false;

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
     * text namespace URL
     */
    const NS_DRAW = 'urn:oasis:names:tc:opendocument:xmlns:drawing:1.0';
	
    /**
     * text namespace URL
     */
    const NS_SCRIPT = 'urn:oasis:names:tc:opendocument:xmlns:script:1.0';
	
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
     * xlink namespace URL
     */
    const NS_MANIFEST = 'urn:oasis:names:tc:opendocument:xmlns:manifest:1.0';

   /**
     * Constructor
     *
     * @param string $filename optional
     *               specify file name if you want to open existing file
     *               to create new document pass nothing or empty string
     * @throws OpenDocument_Exception
     */
    public function __construct($filename = null) {
        if (!empty($filename)) {
			$this->template = $filename;
        } else {
        	$this->create = true;
			$this->template = dirname(__FILE__) . DS . 'template.odt';  
        }

        if (!is_readable($this->template)) {
            die('File not readable');
        }

        //get mimetype
        if (!$this->mimetype = $this->ZipRead($this->template, self::FILE_MIMETYPE))
			die('Different mimetype');

        //get content
        $this->contentDOM = new DOMDocument;
        $this->contentDOM->loadXML($this->ZipRead($this->template, self::FILE_CONTENT));
        $this->contentXPath = new DOMXPath($this->contentDOM);

        //get meta data
        $this->metaDOM = new DOMDocument();
        $this->metaDOM->loadXML($this->ZipRead($this->template, self::FILE_META));
        $this->metaXPath = new DOMXPath($this->metaDOM);

        //get settings
        $this->settingsDOM = new DOMDocument();
        $this->settingsDOM->loadXML($this->ZipRead($this->template, self::FILE_SETTINGS));
        $this->settingsXPath = new DOMXPath($this->settingsDOM);

        //get styles
        $this->stylesDOM = new DOMDocument();
        $this->stylesDOM->loadXML($this->ZipRead($this->template, self::FILE_STYLES));
        $this->stylesXPath = new DOMXPath($this->stylesDOM);

        //get manifest information
        $this->manifestDOM = new DOMDocument();
        $this->manifestDOM->loadXML($this->ZipRead($this->template, self::FILE_MANIFEST));
        $this->manifestXPath = new DOMXPath($this->manifestDOM);
        
        //set cursor
        $this->cursor = $this->contentXPath->query('/office:document-content/office:body/office:text')->item(0);
		$this->styles = $this->contentXPath->query('/office:document-content/office:automatic-styles')->item(0);
    	$this->fonts  = $this->contentXPath->query('/office:document-content/office:font-face-decls')->item(0);
		$this->document  = $this->contentXPath->query('/office:document-content')->item(0);

    	$this->contentXPath->registerNamespace('text', self::NS_TEXT);

		//if($this->create)
			$this->addToManifest('Pictures/','');
    }
	
	function addToManifest($fullPath,$mediaType = '') {
		$manifestCursor = &$this->manifestXPath->query('/manifest:manifest')->item(0);
		
		$fileEntry = $manifestCursor->ownerDocument->createElementNS(OpenDocument::NS_MANIFEST, 'file-entry');
        $fileEntry = $manifestCursor->appendChild($fileEntry);

		$fileEntry->setAttributeNS(OpenDocument::NS_MANIFEST,'media-type',$mediaType);
		$fileEntry->setAttributeNS(OpenDocument::NS_MANIFEST,'full-path',$fullPath);
	}
	
	function importHTML($html) {
		$this->HTMLDOM = new DOMDocument('1.0','utf-8');
		$html = str_replace(array('<embed','</embed'),'',$html); //ugly fix!
		if(empty($html))
			return false;
		
		$html = @mb_convert_encoding($html, 'HTML-ENTITIES', 'utf-8');   
		if(!$this->HTMLDOM->loadHTML($html)) {
			echo 'Could not import the following HTML:';
			echo $html;
			die;
		}

		$this->importHTMLNode($this->HTMLDOM->getElementsByTagName('body')->item(0), &$this->cursor);
		$this->contentDOM->saveXML();
	}
	
	function importHTMLFile($file) {
		//echo($this->contentDOM->saveXML());
		$this->importHTML(file_get_contents($file));
		
		//echo '<pre>';

	}
	
	function setTextDirection() {
		if($this->text_direction == 'lr-tb') {
			return false;
		}

		$temp3 = &$this->stylesXPath->query('/office:document-styles/office:automatic-styles/style:page-layout/style:page-layout-properties')->item(0);
		$temp3->setAttribute('style:writing-mode','rl-tb');
		
		$tags = &$this->stylesXPath->query('//style:paragraph-properties');
		foreach($tags as $tag) {
			$tag->setAttribute('style:writing-mode','rl-tb');
			$tag->setAttribute('fo:text-align','end');
		}
		
		$tags = &$this->contentXPath->query('//style:paragraph-properties');
		foreach($tags as $tag) {
			$tag->setAttribute('style:writing-mode','rl-tb');
			$tag->setAttribute('fo:text-align','end');
		}
	}
	
	public function appendTableOfContents() {
		$temp = &$this->contentXPath->query('/office:document-content/office:body/office:text/text:table-of-content/text:table-of-content-source/text:index-title-template/text()')->item(0);
		$temp->nodeValue = __('Table of Contents',true);
		
		$temp2 = &$this->contentXPath->query('/office:document-content/office:body/office:text/text:table-of-content/text:index-body/text:index-title/text:p/text()')->item(0);
		$temp2->nodeValue = __('Table of Contents',true);
		
		return true; // This function is being phased out...
		
		$node = &$this->cursor;
		
		$tableOfContent = $node->ownerDocument->createElementNS(OpenDocument::NS_TEXT, 'table-of-content');
        $tableOfContent = $node->appendChild($tableOfContent);

		$tableOfContentSource = $node->ownerDocument->createElementNS(OpenDocument::NS_TEXT, 'table-of-content-source');
		$tableOfContentSource->setAttributeNS(OpenDocument::NS_TEXT,'text:outline-level','3');
        $tableOfContentSource = $tableOfContent->appendChild($tableOfContentSource);
		
		$indexTitleTemplate = $node->ownerDocument->createElementNS(OpenDocument::NS_TEXT, 'index-title-template');
        $indexTitleTemplate = $tableOfContentSource->appendChild($indexTitleTemplate);
		
		$title = $node->ownerDocument->createTextNode(__('Table of Contents',true));
        $title = $indexTitleTemplate->appendChild($title);
		
		for($level = 1; $level < 5; $level++) {
			$tableOfContentEntryTemplate = $node->ownerDocument->createElementNS(OpenDocument::NS_TEXT, 'table-of-content-entry-template');
			$tableOfContentEntryTemplate->setAttributeNS(OpenDocument::NS_TEXT,'outline-level',$level);
		    $tableOfContentEntryTemplate = $tableOfContentSource->appendChild($tableOfContentEntryTemplate);			

			$indexEntryChapter = $node->ownerDocument->createElementNS(OpenDocument::NS_TEXT, 'index-entry-chapter');
			$indexEntryChapter = $tableOfContentEntryTemplate->appendChild($indexEntryChapter);
			
			$indexEntryText = $node->ownerDocument->createElementNS(OpenDocument::NS_TEXT, 'index-entry-text');
	        $indexEntryText = $tableOfContentEntryTemplate->appendChild($indexEntryText);
			
			$indexEntryTabStop = $node->ownerDocument->createElementNS(OpenDocument::NS_TEXT, 'index-entry-tab-stop');
			$indexEntryTabStop->setAttributeNS(OpenDocument::NS_STYLE,'style:type','right');
			$indexEntryTabStop->setAttributeNS(OpenDocument::NS_STYLE,'style:leader-char','.');
	        $indexEntryTabStop = $tableOfContentEntryTemplate->appendChild($indexEntryTabStop);

			$indexEntryPageNumber = $node->ownerDocument->createElementNS(OpenDocument::NS_TEXT, 'index-entry-page-number');
	        $indexEntryPageNumber = $tableOfContentEntryTemplate->appendChild($indexEntryPageNumber);
		}
		
		$indexBody = $node->ownerDocument->createElementNS(OpenDocument::NS_TEXT, 'index-body');
        $indexBody = $tableOfContent->appendChild($indexBody);
		
		$this->tocIndexBody = &$indexBody;
		
		$indexTitle = $node->ownerDocument->createElementNS(OpenDocument::NS_TEXT, 'index-title');
        $indexTitle = $tableOfContent->appendChild($indexTitle);
		
		$indexBodyParagraph = $this->appendParagraph($indexTitle);
		$indexBodyParagraphText = $this->appendTextElement($indexBodyParagraph,__('Table of Contents',true));
		
		//<script:event-listener script:language="ooo:script" script:event-name="dom:load"
		//		xlink:href="vnd.sun.star.script:Standard.ToC.Main?language=Basic&amp;location=document"/>
		
		// Add event listener
		$scripts = $node->ownerDocument->createElementNS(OpenDocument::NS_OFFICE, 'office:scripts');
		$eventListeners = $node->ownerDocument->createElementNS(OpenDocument::NS_OFFICE, 'office:event-listeners');
		$scripts->appendChild($eventListeners);
		$this->document->appendChild($scripts);
		
		$eventListener = $node->ownerDocument->createElementNS(OpenDocument::NS_SCRIPT, 'script:event-listener');
		$eventListener->setAttributeNS(OpenDocument::NS_SCRIPT,'script:language','ooo:script');
		$eventListener->setAttributeNS(OpenDocument::NS_SCRIPT,'script:event-name','dom:load');
		$eventListener->setAttributeNS(OpenDocument::NS_XLINK,'xlink:href','vnd.sun.star.script:Standard.ToC.Main?language=Basic&location=document');
        $eventListener = $node->appendChild($eventListener);
		$eventListeners->appendChild($eventListener);
	}
	
	function appendTocItem($level,$text){
		if($level < 5) {
			$tocIndexParagraph = $this->appendParagraph($this->tocIndexBody);
			$tocIndexParagraph = $this->appendTextElement($tocIndexParagraph,$text);

			$tocIndexTab = $node->ownerDocument->createElementNS(OpenDocument::NS_TEXT, 'tab');
	        $tocIndexTab = $tocIndexParagraph->appendChild($tocIndexTab);
			
			$tocIndexPageNumber = $this->appendParagraph($this->tocIndexBody);
			$tocIndexPageNumber = $this->appendTextElement($tocIndexPageNumber,$text);
		}
	}
	
	function appendHeading(&$node,$level,$styles = null) {
		$element = $node->ownerDocument->createElementNS(OpenDocument::NS_TEXT, 'h');
		$element->setAttributeNS(OpenDocument::NS_TEXT,'outline-level',$level);
        $element = $node->appendChild($element);
		
		if($level < 2) {
			$this->applyStyles($element,'paragraph',array('fo:break-before' => 'page'),'Heading');
		}		
		//style:parent-style-name="Heading"
		
		return $element;
	}
	
	function appendParagraph(&$node,$styles = array('margin-top'=>'0.0799in','margin-bottom'=>'0.0799in')) {
		$element = $node->ownerDocument->createElementNS(OpenDocument::NS_TEXT, 'p');
        $element = $node->appendChild($element);
		
		self::applyStyles($element,'paragraph',$styles);
		
		return $element;
	}
	
	function applyStyles(&$node,$family,$styles = null,$parentStyle = null) {
		if(!$styles)
			return false;
		
		$id = uniqid();
			
		$styleElement = $node->ownerDocument->createElementNS(OpenDocument::NS_STYLE, 'style');
		$styleElement->setAttributeNS(OpenDocument::NS_STYLE,'family',$family);
		$styleElement->setAttributeNS(OpenDocument::NS_STYLE,'name',$id);
		if($parentStyle) {
			$styleElement->setAttributeNS(OpenDocument::NS_STYLE,'parent-style-name',$parentStyle);			
		}
		$this->styles->appendChild($styleElement);
		
		switch($family) {
			case 'paragraph':
				$propertiesElement = $node->ownerDocument->createElementNS(OpenDocument::NS_STYLE, 'paragraph-properties');
				//style:writing-mode
				break;
			default:
				$propertiesElement = $node->ownerDocument->createElementNS(OpenDocument::NS_STYLE, 'text-properties');
				break;
		}
		$styleElement->appendChild($propertiesElement);
		
		foreach($styles as $styleName => $value) {
			$propertiesElement->setAttributeNS(OpenDocument::NS_FO,$styleName,$value);
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
	
	function appendImage(&$node,$src,$styles = null) {
		$original_source = $src;
		if(stripos($src,$this->imagePrefix) !== 0)
			return false;

		$src = str_ireplace($this->imagePrefix,'',$src);
		
		$tempfile = tempnam(null,null);
		$handle = fopen($tempfile, 'w');
		
		$headers = get_headers($this->s3Prefix . $src);
		if($headers[0] != 'HTTP/1.1 200 OK')
			return null;
		
		fwrite($handle, file_get_contents($this->s3Prefix . $src));
		fclose($handle);

		//write image to zip file
        if (!$this->zipAddFile('Pictures/' . $src, $tempfile)) {
            die('Error1');
            throw new OpenDocument_Exception(OpenDocument_Exception::WRITE_IMAGE_ERR);
        }

		
		$this->addToManifest('Pictures/' . $src,'image/jpeg');
		
		$frame = $node->ownerDocument->createElementNS(OpenDocument::NS_DRAW, 'frame');
        $frame = $node->appendChild($frame);

		$frame->setAttributeNS(OpenDocument::NS_TEXT,'anchor-type','as-char');
		
		list($width, $height, $type, $attr) = getimagesize($tempfile);
		unlink($tempfile);
		
		$frame->setAttributeNS(OpenDocument::NS_SVG,'width',($width / 100) . 'in');
		$frame->setAttributeNS(OpenDocument::NS_SVG,'height',($height / 100) . 'in');
		
		//<draw:frame draw:style-name="fr1" draw:name="graphics1" text:anchor-type="as-char" svg:width="4.1665in" svg:height="2.778in" draw:z-index="0">
		
		$image = $node->ownerDocument->createElementNS(OpenDocument::NS_DRAW, 'image');
        $image = $frame->appendChild($image);
		
		$image->setAttributeNS(OpenDocument::NS_XLINK,'type','simple');
		$image->setAttributeNS(OpenDocument::NS_XLINK,'show','embed');
		$image->setAttributeNS(OpenDocument::NS_XLINK,'actuate','onLoad');		
		$image->setAttributeNS(OpenDocument::NS_XLINK,'href','Pictures/' . $src);
		
		return $frame;
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
				
			case 'img':
				$newODTNode = $this->appendImage(&$ODTNode,$HTMLNode->getAttribute('src'));
				break;	
				
			case 'embed':
				$newODTNode = &$ODTNode;
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
		if($this->create) {
	        //write mimetype
	        if (!$this->zipWrite($filename, self::FILE_MIMETYPE, $this->mimetype)) {
	            die('Error mimetype');
				throw new OpenDocument_Exception(OpenDocument_Exception::WRITE_MIMETYPE_ERR);
	        }			

	        //write meta
	        $xml = str_replace("'", '&apos;', $this->metaDOM->saveXML());
	        if (!$this->zipWrite($filename, self::FILE_META, $xml)) {
	            die('Error');
	            throw new OpenDocument_Exception(OpenDocument_Exception::WRITE_META_ERR);
	        }
		}
		
		//write content
        $xml = str_replace("'", '&apos;', $this->contentDOM->saveXML());
        if (!$this->zipWrite($filename, self::FILE_CONTENT, $xml)) {
            die('Error content');
            throw new OpenDocument_Exception(OpenDocument_Exception::WRITE_CONTENT_ERR);
        }

        //write settings
        $xml = str_replace("'", '&apos;', $this->settingsDOM->saveXML());
        if (!$this->zipWrite($filename, self::FILE_SETTINGS, $xml)) {
            die('Error');
            throw new OpenDocument_Exception(OpenDocument_Exception::WRITE_SETTINGS_ERR);
        }

        //write styles
        $xml = str_replace("'", '&apos;', $this->stylesDOM->saveXML());
        if (!$this->zipWrite($filename, self::FILE_STYLES, $xml)) {
            die('Error');
            throw new OpenDocument_Exception(OpenDocument_Exception::WRITE_STYLES_ERR);
        }

        //write manifest
        $xml = str_replace("'", '&apos;', $this->manifestDOM->saveXML());
        if (!$this->zipWrite($filename, self::FILE_MANIFEST, $xml)) {
            die('Error');
            throw new OpenDocument_Exception(OpenDocument_Exception::WRITE_MANIFEST_ERR);
        }
		
		$filesToCopyFromTemplate = array(
			'Basic/script-lc.xml',
			'Basic/Standard/script-lb.xml',
			'Basic/Standard/ToC.xml'
		);
		
		if($this->create) {
			foreach($filesToCopyFromTemplate as $file) {
				$this->zipWrite($filename, $file, $this->ZipRead($this->template, $file));			
			}
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
	
    public static function zipRead($archive, $filename) {
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

        if(file_exists($archive)) {
			$zip->open(realpath($archive));
        } else {
            $zip->open($archive, ZipArchive::CREATE);
        }

        if ($zip->locateName($filename) !== false) {
            $zip->deleteName($filename);
        }
        $error = $zip->addFromString($filename, $content);

        return $error;
    }
    
    public function zipAddFile($localname, $filename) {
		$zip = new ZipArchive;
		$archive = $this->destinationFile;
        if (file_exists($archive)) {
            $zip->open(realpath($archive));
        } else {
			$zip->open($archive, ZipArchive::CREATE);
        }

        if ($zip->locateName($localname) !== false) {
		    $zip->deleteName($localname);
        }

		//var_dump(file_exists($filename));
        $error = $zip->addFile($filename, $localname) or die ("Could not add file: $localname");

        return $error;
    }
}

function get_file($file, $local_path, $newfilename) {
    $out = fopen($newfilename, 'wb');
    if ($out == FALSE){
      print "File not opened<br>";
      exit;
    }
   
    $ch = curl_init();
           
    curl_setopt($ch, CURLOPT_FILE, $out);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_URL, $file);
               
    curl_exec($ch);
    echo "<br>Error is : ".curl_error ( $ch);
   
    curl_close($ch);
    //fclose($handle);

}