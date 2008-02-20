<?
/**
 * Contains a edit course textbooks test case for selenium.
 *
 * @package    GCLMS
 * @subpackage SeleniumTests
 * @filesource
 */

uses('model' . DS . 'connection_manager');

/**
 * Edit Course Textbooks selenium test case.
 *
 * @author     Brandon Tanner <theletterpi@gmail.com>
 * @version    1.2 Jan 1, 2008
 * @package    GCLMS
 * @subpackage SeleniumTests
 * @todo       The delete textbook part fails in the selenium runner.
 */
class EditTextbooksTest extends SeleniumTestCase {
    var $title = 'Edit Textbooks';
    var $useDbConfig = 'default';
    
    function execute() {
        $this->open('/users/logout');
        $this->type('UserUsername', 'aaronshaf');
		$this->type('UserPassword', 'test');
		$this->clickAndWait("//input[@value='Login']");
		$this->assertBadTextNotPresent();
		
		$this->clickAndWait("link=Boyce College");
		$this->clickAndWait("link=Systematic Theology");
		$this->clickAndWait("link=Edit Textbooks");
		
		/* Add a new Textbook */
		$this->addTextbook('The Hermeneutical Spiral');
		$this->addTextbook('Desiring God');
		$this->addTextbook('Finite Math');
    	
    	/* Now Edit a Textbook */
		// This is already done in the chapters test.
		
		/* Rename a Textbook */
		$this->click('link=Finite Math');
		$this->click('renameTextbook');
		$this->pause(100);
		$this->type('gclmsPopupDialogInputText', 'Mathematics for Statistics');
		$this->click('gclmsPopupDialogOkButton');
		$this->assertBadTextNotPresent();
    	
    	/* Now Delete a Textbook */
		$this->click('link=Mathematics for Statistics');
		$this->click('deleteTextbook');
		$this->pause(100);
		$this->click('gclmsPopupDialogOkButton');
		$this->assertTextNotPresent('Mathematics for Statistics');
		$this->assertBadTextNotPresent();
    }
	
	function addTextbook($title) {
		$this->click('addTextbook');
		$this->pause(100);
		$this->type('gclmsPopupDialogInputText',$title);
		$this->click('gclmsPopupDialogOkButton');
		$this->pause(500);
	}
}