<?
class AppError extends ErrorHandler {
	function permission() {
		$this->_outputMessage('permission');
	}
	
	function missingController($params) {
		$this->controller->layout = 'blank';
		parent::missingController($params);
	}
	
	function missingComponentClass($params) {
		$this->controller->layout = 'blank';
		parent::missingComponentClass($params);
	}
}