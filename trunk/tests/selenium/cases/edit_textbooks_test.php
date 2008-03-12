<?
/**
 * Contains a edit course books test case for selenium.
 *
 * @package    GCLMS
 * @subpackage SeleniumTests
 * @filesource
 */

uses('model' . DS . 'connection_manager');

/**
 * Edit Course Books selenium test case.
 *
 * @author     Brandon Tanner <theletterpi@gmail.com>
 * @version    1.2 Jan 1, 2008
 * @package    GCLMS
 * @subpackage SeleniumTests
 * @todo       The delete book part fails in the selenium runner.
 */
class EditBooksTest extends SeleniumTestCase {
    var $title = 'Edit Books';
    var $useDbConfig = 'default';
    
    function execute() {
        $this->open('/users/logout');
        $this->type('UserUsername', 'aaronshaf');
		$this->type('UserPassword', 'test');
		$this->clickAndWait("//input[@value='Login']");
		$this->assertBadTextNotPresent();
		
		$this->clickAndWait("link=Boyce College");
		$this->clickAndWait("link=Systematic Theology");
		$this->clickAndWait("link=Edit Books");
		
		/* Add a new Book */
		$this->addBook('The Hermeneutical Spiral');
		$this->addBook('Desiring God');
		$this->addBook('Finite Math');
    	
    	/* Now Edit a Book */
		// This is already done in the chapters test.
		
		/* Rename a Book */
		$this->click('link=Finite Math');
		$this->click('renameBook');
		$this->pause(100);
		$this->type('gclmsPopupDialogInputText', 'Mathematics for Statistics');
		$this->click('gclmsPopupDialogOkButton');
		$this->assertBadTextNotPresent();
    	
    	/* Now Delete a Book */
		$this->click('link=Mathematics for Statistics');
		$this->click('deleteBook');
		$this->pause(100);
		$this->click('gclmsPopupDialogOkButton');
		$this->assertTextNotPresent('Mathematics for Statistics');
		$this->assertBadTextNotPresent();
    }
	
	function addBook($title) {
		$this->click('addBook');
		$this->pause(100);
		$this->type('gclmsPopupDialogInputText',$title);
		$this->click('gclmsPopupDialogOkButton');
		$this->pause(500);
	}
}