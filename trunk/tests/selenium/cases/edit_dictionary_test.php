<?
/**
 * Contains a edit course glossary test case for selenium.
 *
 * @package    GCLMS
 * @subpackage SeleniumTests
 * @filesource
 */

uses('model' . DS . 'connection_manager');

/**
 * Edit Course Glossary selenium test case.
 *
 * @author     Brandon Tanner <theletterpi@gmail.com>
 * @version    1.1 Jan 1, 2008
 * @package    GCLMS
 * @subpackage SeleniumTests
 */
class EditGlossaryTest extends SeleniumTestCase {
    var $title = 'Edit Glossary';
    var $useDbConfig = 'default';
    
    function execute() {
        $this->open('/users/logout');
        $this->type('UserUsername', 'aaronshaf');
		$this->type('UserPassword', 'test');
		$this->clickAndWait("//input[@value='Login']");
		$this->assertBadTextNotPresent();
		
		$this->clickAndWait("link=Boyce College");
		$this->clickAndWait("link=Systematic Theology");
		$this->clickAndWait("link=Edit Glossary");
		
		/* Add a glossary term */
		$this->addGlossaryTerm('Justification','The declaration that someone is rightous on account of the imputed righteousness of Jesus Christ.');
		$this->addGlossaryTerm('Sanctification','The process of becoming more like Christ.');
		$this->addGlossaryTerm('PHP','PHP Hypertext Preprocessor');
    	
    	/* Edit a glossary term */
		$this->clickAndWait('link=PHP');
    	$this->type('GlossaryTermTerm', 'Ruby');
		$this->assertTextPresent('PHP Hypertext Preprocessor');
		$this->verifyEval("selenium.browserbot.getCurrentWindow().tinyMCE.setContent('A newer language.')",'null');
    	$this->clickAndWait("//input[@value='Save']");
    	$this->assertBadTextNotPresent();
		$this->assertTextPresent('successfully saved');
		$this->assertTextPresent('Ruby');
		$this->clickAndWait('link=Ruby');
		$this->assertTextPresent('A newer language.');
    	
    	/* Delete a glossary term */
    	$this->click("//input[@value='Delete']");
		$this->clickAndWait('gclmsPopupDialogOkButton');
    	$this->assertBadTextNotPresent();
		$this->assertTextPresent('successfully deleted');
		$this->assertTextNotPresent('PHP');
		$this->assertTextNotPresent('Ruby');

    }
	
	function addGlossaryTerm($term,$definition) {
		$this->clickAndWait('gclmsAdd');
		$this->type('GlossaryTermTerm', $term);
		$this->verifyEval("selenium.browserbot.getCurrentWindow().tinyMCE.setContent('" . $definition . "')",'null');
    	$this->clickAndWait("//input[@value='Save']");
    	$this->assertBadTextNotPresent();
		$this->assertTextPresent('successfully added');
	}
}