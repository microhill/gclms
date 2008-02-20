<?
/**
 * Contains a edit course dictionary test case for selenium.
 *
 * @package    GCLMS
 * @subpackage SeleniumTests
 * @filesource
 */

uses('model' . DS . 'connection_manager');

/**
 * Edit Course Dictionary selenium test case.
 *
 * @author     Brandon Tanner <theletterpi@gmail.com>
 * @version    1.1 Jan 1, 2008
 * @package    GCLMS
 * @subpackage SeleniumTests
 */
class EditDictionaryTest extends SeleniumTestCase {
    var $title = 'Edit Dictionary';
    var $useDbConfig = 'default';
    
    function execute() {
        $this->open('/users/logout');
        $this->type('UserUsername', 'aaronshaf');
		$this->type('UserPassword', 'test');
		$this->clickAndWait("//input[@value='Login']");
		$this->assertBadTextNotPresent();
		
		$this->clickAndWait("link=Boyce College");
		$this->clickAndWait("link=Systematic Theology");
		$this->clickAndWait("link=Edit Dictionary");
		
		/* Add a dictionary term */
		$this->addDictionaryTerm('Justification','The declaration that someone is rightous on account of the imputed righteousness of Jesus Christ.');
		$this->addDictionaryTerm('Sanctification','The process of becoming more like Christ.');
		$this->addDictionaryTerm('PHP','PHP Hypertext Preprocessor');
    	
    	/* Edit a dictionary term */
		$this->clickAndWait('link=PHP');
    	$this->type('DictionaryTermTerm', 'Ruby');
		$this->assertTextPresent('PHP Hypertext Preprocessor');
		$this->verifyEval("selenium.browserbot.getCurrentWindow().tinyMCE.setContent('A newer language.')",'null');
    	$this->clickAndWait("//input[@value='Save']");
    	$this->assertBadTextNotPresent();
		$this->assertTextPresent('successfully saved');
		$this->assertTextPresent('Ruby');
		$this->clickAndWait('link=Ruby');
		$this->assertTextPresent('A newer language.');
    	
    	/* Delete a dictionary term */
    	$this->click("//input[@value='Delete']");
		$this->clickAndWait('gclmsPopupDialogOkButton');
    	$this->assertBadTextNotPresent();
		$this->assertTextPresent('successfully deleted');
		$this->assertTextNotPresent('PHP');
		$this->assertTextNotPresent('Ruby');

    }
	
	function addDictionaryTerm($term,$definition) {
		$this->clickAndWait('gclmsAdd');
		$this->type('DictionaryTermTerm', $term);
		$this->verifyEval("selenium.browserbot.getCurrentWindow().tinyMCE.setContent('" . $definition . "')",'null');
    	$this->clickAndWait("//input[@value='Save']");
    	$this->assertBadTextNotPresent();
		$this->assertTextPresent('successfully added');
	}
}