<?
class MediaFilesHelper extends AppHelper {
	function transform_to_s3_links($text,$course_id) {
		Configure::load('s3');
		$bucket = Configure::read('S3.bucket');
		
		$pattern = 'src="../../files/';
		$replacement = 'src="http://' . $bucket . '.s3.amazonaws.com/courses/' . $course_id . '/';
		$text = str_replace($pattern, $replacement, $text);

		$pattern = 'value="../../files/';
		$replacement = 'value="http://' . $bucket . '.s3.amazonaws.com/courses/' . $course_id . '/';
		$text = str_replace($pattern, $replacement, $text);
		
		return $text;
	}
}