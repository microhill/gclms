<?
/**
 * Contains a add/edit/delete facilitated class test case for selenium.
 *
 * @package    GCLMS
 * @subpackage SeleniumTests
 * @filesource
 */

uses('model' . DS . 'connection_manager');

/**
 * Add/Edit/Delete Facilitated Class selenium test case.
 *
 * @author     Brandon Tanner
 * @version    1.2 Dec 28, 2007
 * @package    GCLMS
 * @subpackage SeleniumTests
 * @todo       Should this page allow you to add duplicate classes? Cause it does. Also, delete currently not working.
 */
class FacilitatedClassTest extends SeleniumTestCase {
    var $title = 'Facilitated Class Test';
    var $useDbConfig = 'default';
	
    function execute() {
        $this->open('/users/logout');
        $this->type('UserUsername', 'aaronshaf');
		$this->type('UserPassword', 'test');
		$this->clickAndWait("//input[@value='Login']");
		$this->assertBadTextNotPresent();
		
		$this->clickAndWait("link=Boyce College");
		$this->clickAndWait("link=Facilitated Classes");
		
		$this->clickAndWait("gclmsAdd"); //click add button
		$this->addFacilitatedClass('TestFacClass1', 'Systematic Theology', 'Online', '30');
		
		$this->clickAndWait("gclmsAdd"); //click add button
		$this->addFacilitatedClass('TestFacClass2', 'Hermeneutics 101', 'Inperson', '20');
		
		// Now Edit One of them
		$this->clickAndWait('link=TestFacClass1');
		$this->click("FacilitatedClassType2");
		$this->type("FacilitatedClassCapacity", "50");
		$this->clickAndWait("//input[@value='Save']");
		$this->assertBadTextNotPresent();
		
		// Now Delete one of them
		$this->clickAndWait('link=TestFacClass2');
		$this->clickAndWait("//input[@value='Delete']");
		//$this->clickAndWait('gclmsPopupDialogOkButton');
		$this->assertBadTextNotPresent();
		//$this->assertTextPresent('successfully deleted');
		//$this->assertTextNotPresent('TestFacClass2');

    }
	
	/**
	 * Add a Facilitated Class.
	 * 
	 * The course must already exist, so make sure you are using one that is already in
	 * the dropdown select box. Also, type must be Online or Inperson.
	 * 
	 * @param string  $alias  Class Alias, this can be anything you want.
	 * @param string  $course Course, must already exist, can't make something up.
	 * @param string  $type   Class type, must be Online or Inperson.
	 * @param integer $maxcap The class capacity of students.
	 */
	protected function addFacilitatedClass($alias, $course, $type, $maxcap) {
		$this->type('FacilitatedClassAlias', $alias);
		$this->select("FacilitatedClassCourseId", "label=".$course);
		if ($type == "Online") {
			$this->click("FacilitatedClassType1"); // Online
		} 
		else {
			$this->click("FacilitatedClassType2"); // In-Person
		}
		$this->select("FacilitatedClassEnrollmentDeadlineMonth", "label=March");
		$this->select("FacilitatedClassBeginningMonth", "label=April");
		$this->select("FacilitatedClassEndMonth", "label=June");
		$this->type("FacilitatedClassCapacity", $maxcap);
		$this->clickAndWait("//input[@value='Save']");
		$this->assertBadTextNotPresent();
	}
	   
}