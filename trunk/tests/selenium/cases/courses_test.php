<?
/**
 * Contains a add/edit/delete course test case for selenium.
 *
 * @package    GCLMS
 * @subpackage SeleniumTests
 * @filesource
 */

uses('model' . DS . 'connection_manager');

/**
 * Add/Edit/Delete Course selenium test case.
 *
 * @author     Brandon Tanner
 * @version    1.3 Jan 4, 2008
 * @package    GCLMS
 * @subpackage SeleniumTests
 * @todo       Uncomment the delete course part after the bug to delete a course is fixed. Also, fix the tinymce when it is working again.
 */
class CoursesTest extends SeleniumTestCase {
    var $title = 'Courses Setup';
    var $useDbConfig = 'default';
	
    function execute() {
        $this->open('/users/logout');
        $this->type('UserUsername', 'aaronshaf');
		$this->type('UserPassword', 'test');
		$this->clickAndWait("//input[@value='Login']");
		$this->assertBadTextNotPresent();
		
		// Add a few Courses
		$this->clickAndWait("link=Boyce College");
		$this->clickAndWait("link=Add Course");

		$this->addCourse('Systematic Theology','systematic-theology','<p>Introduction to theology.</p>');
        $this->open('/boyce-college');
		$this->clickAndWait("link=Add Course");
		
		$this->addCourse('Hermeneutics 101','hermeneutics-101','<p>How to interpret the Bible.</p>');
        $this->open('/boyce-college');
		$this->clickAndWait("link=Add Course");
		
		$this->addFullCourse('Learning phpdoc', 'learn-phpdoc', 'Kiswahili', 0, 'Learning PhpDocumentor in 24 Hours.', '');
		
		// Edit Course
		$this->clickAndWait("link=Configure Course");
		$this->type('CourseTitle', 'Learning PhpDocumentor');
		$this->clickAndWait("//input[@value='Save']");
		$this->assertBadTextNotPresent();
		$this->assertTextPresent('Course successfully saved.');
		
		// Delete Course
		// $this->clickAndWait("link=Configure Course");
		// $this->clickAndWait('CourseDelete');
		// $this->assertConfirmation('Are you sure you want to delete this course?');
		// $this->assertBadTextNotPresent();
    }
    
	/**
	 * Helper method to add a new course.
	 * 
	 * Language defaults to English, makes course redistributeable
	 * and sets the custom css field to nothing.
	 * 
	 * @param string $title       The Course Title
	 * @param string $webpath     The Course Webpath
	 * @param string $description The Course Description
	 */
	function addCourse($title, $webpath, $description) {
		$this->addFullCourse($title, $webpath, "English", 1, $description, "");
	}
	
	/**
	 * Add a new Course.
	 *  
	 * @param string  $title        The Course Title
	 * @param string  $webpath      The Course Webpath
	 * @param string  $language     The Course Language
	 * @param integer $redistribute A "1" or a "0" to make the course redistributable
	 * @param string  $description  The Course Description
	 * @param string  $customcss    Any custom CSS for this course
	 */
    function addFullCourse($title, $webpath, $language, $redistribute, $description, $customcss) {
		$this->type('CourseTitle', $title);
		$this->type('CourseWebPath', $webpath);
		$this->select('CourseLanguage', 'label='.$language);
		if ($redistribute) {
			$this->click('CourseRedistributionAllowed1');
		}
		else {
			$this->click('CourseRedistributionAllowed0');
		}
		//Uncomment this when tinymce starts working on this page.
		$this->verifyEval("selenium.browserbot.getCurrentWindow().tinyMCE.setContent('".strip_tags($description)."')",'null');
		//$this->type('CourseDescription', $description);
		$this->type('CourseCss', $customcss);
		$this->clickAndWait("//input[@value='Save']");
		$this->assertBadTextNotPresent();
		$this->assertTextPresent('Course successfully added.');
    }
    
}