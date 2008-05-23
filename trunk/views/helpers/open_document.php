<?
class OpenDocumentHelper extends AppHelper {
	function export($data) {
		$this->data = $data;
		App::import('Vendor', 'open_document'. DS . 'open_document');
		$destinationFile = TMP . 'export' . DS . $this->data['course']['id'] . '.odt';
		
		if($data['stage'] > 0) {
			$this->openDocument = new OpenDocument($destinationFile);
		} else {
			$this->openDocument = new OpenDocument;
		}
		
		$this->openDocument->mediaDirectory = ROOT . DS . APP_DIR . DS . 'files' . DS . 'courses' . DS . $this->data['course']['id'];
		$this->openDocument->imagePrefix = '/' . $this->data['group']['web_path'] . '/' . $this->data['course']['web_path'] . '/files/';
		$this->openDocument->destinationFile = 	$destinationFile;
		$this->openDocument->text_direction = $data['text_direction'] == 'rtl' ? 'rl-tb' : 'lr-tb';

		if($data['stage'] <= count($data['nodes'])) {
			if($data['stage'] == 0) {
				$this->openDocument->create = true;
				
				if(file_exists($this->openDocument->destinationFile))
					unlink($this->openDocument->destinationFile);
				
				$this->openDocument->appendTableOfContents();
			} else {
				if(!file_exists($this->openDocument->destinationFile))
					die('Could not find ' . $this->openDocument->destinationFile);

				$nodeNum = $data['stage'] - 1;
				$this->export_node_to_odt($this->data['nodes'][$nodeNum]);
			}
		} else {
			$postNodesStage = $data['stage'] - count($data['nodes']);
			
			switch($postNodesStage) {
				case 1:
					// Appendix
					$this->openDocument->importHTML('<h1>' . __('Appendix',true) . '</h1>');

					//Articles
					if(!empty($this->data['articles'])) {
						$this->openDocument->importHTML('<h2>' . __('Articles',true) . '</h2>');
						
						foreach($this->data['articles'] as $article) {
							$this->openDocument->importHTML('<h3>' . $article['Article']['title'] . '</h3>');
							$article['Article']['content'] = $this->prepareTextForODT($article['Article']['content']);
							$this->openDocument->importHTML($article['Article']['content']);
						}
					}
					
					break;
				case 2:
					//Glossary terms
					$this->openDocument->importHTML('<h2>' . __('Glossary',true) . '</h2>');
					foreach($this->data['glossary_terms'] as $glossary_term) {
						$this->openDocument->importHTML('<h4>' . $glossary_term['GlossaryTerm']['term'] . '</h4>');
						$glossary_term['GlossaryTerm']['description'] = $this->prepareTextForODT($glossary_term['GlossaryTerm']['description']);
						$this->openDocument->importHTML($glossary_term['GlossaryTerm']['description']);
					}
					
					$this->openDocument->setTextDirectionality();
					
					//unlink(TMP.'export' . DS . $data['course']['id'] . '.tmp');
					
					break;
				case 3:
					//Books

			}
		}
		
		$this->openDocument->save($this->openDocument->destinationFile);
		return array(
			'stage' => $data['stage'],
			'totalStages' => count($data['nodes']) + 2
		);
	}
	
	function export2($data) {
		/*
		// Node structure
		echo '<br/>Total: ' . $this->data['node_count'] . '<br/>';
		$this->nodeIncrement = 0;

		foreach($this->data['nodes'] as $node) {
			$this->export_node_to_odt($node);
		}
		*/

		// Books
		


		exit;
 // Needed to keep .zip from being corrupted
	}
	
	private function prepareTextForODT($string) {
		$string = str_replace(array("\n"),array(' '),$string);
		$string = str_replace(array('<h1','/h1'),array('<h4','/h4'),$string);
		$string = str_replace(array('<h2','/h2'),array('<h4','/h4'),$string);
		$string = str_replace(array('<h3','/h3'),array('<h5','/h5'),$string);
		$string = str_replace(array('<h4','/h4'),array('<h6','/h6'),$string);
		$string = str_replace(array('<h5','/h5'),array('<strong','/strong'),$string);
		$string = str_replace(array('<h6','/h6'),array('<em','/em'),$string);

		$string = strip_tags($string,'<h4><h5><h6><i><em><strong><b><u><ul><ol><li><p><div><span><table><tbody><tr><th><td><img><a>');
		return $string;
	}
	
	private function export_question($question) {
		$title = '<p><strong>' . $question['title'] . '</strong></p>';
		$this->openDocument->importHTML($title);
		$this->answerKey .= $title;
		$orderedLetters = range('a','z');

		switch($question['type']) {
			case '0': // Multiple choice
				reset($orderedLetters);
				foreach($question['Answer'] as $answer) {
					$this->openDocument->importHTML('<p>' . current($orderedLetters) . '. ' . $answer['text1'] . '</p>');
					if($answer['correct']) {
						$this->answerKey .= '<p>' . current($orderedLetters) . '. ' . $answer['text1'] . '</p>';
					}
					next($orderedLetters);
				}

				break;
			case '1': // True / false
				$this->openDocument->importHTML('<p><em>True or false</em></p>');
				$this->answerKey .= '<p><em>' . ($question['true_false_answer'] ? __('True',true) : __('False',true)) . '</em></p>';
				$this->answerKey .= $question['explanation'];
				break;
			case '2': // Matching
				reset($orderedLetters);
				$answersHTML = '<table>';
				foreach($question['Answer'] as $answer) {
					$answersHTML .= '<tr>';

					$answersHTML .= '<td>_____ ' . $answer['text1'] . '</td>';
					$answersHTML .= '<td>' . current($orderedLetters) . '. ' . $answer['text2'] . '<br/><br/></td>';

					$answersHTML .= '</tr>';

					next($orderedLetters);
				}
				$answersHTML .= '</table>';
				$this->openDocument->importHTML($answersHTML);

				reset($orderedLetters);
				$answersHTML = '<table>';
				foreach($question['Answer'] as $answer) {
					$answersHTML .= '<tr>';

					$answersHTML .= '<td>__' . current($orderedLetters) . '__ ' . $answer['text1'] . '</td>';
					$answersHTML .= '<td>' . current($orderedLetters) . '. ' . $answer['text2'] . '<br/><br/></td>';

					$answersHTML .= '</tr>';

					next($orderedLetters);
				}
				$answersHTML .= '</table>';
				$this->answerKey .= $answersHTML;
				$this->answerKey .= $question['explanation'];
				break;
			case '3': // Ordered list
				reset($orderedLetters);
				foreach($question['Answer'] as $answer) {
					$this->openDocument->importHTML('<p>' . current($orderedLetters) . '. ' . $answer['text1'] . '</p>');
					$this->answerKey .= '<p>' . current($orderedLetters) . '. ' . $answer['text1'] . '</p>';
					next($orderedLetters);
				}
				$this->answerKey .= $question['explanation'];
				break;

			case '4': // Fill in the blank
				$this->openDocument->importHTML('<p></p><p></p>');
				$this->answerKey .= '<p><em>' . $question['text_answer'] . '</em></p>';
				$this->answerKey .= $question['explanation'];
				break;
			case '5': // Essay
				$this->openDocument->importHTML('<p></p><p></p><p></p><p></p><p></p><p></p>');
				$this->answerKey .= $question['explanation'];
				break;
		}
	}
	
	function getSortedNodeItems($node) {
		$nodeItems = array();
		foreach($node['Textarea'] as $textarea) {
			$nodeItems[$textarea['order']] = $textarea;
		}

		foreach($node['Question'] as $question) {
			$nodeItems[$question['order']] = $question;
		}
		ksort($nodeItems);
		
		return $nodeItems;
	}
	
	private function export_node_to_odt($node,$level = 1) {
		$this->nodeIncrement++;

		$this->openDocument->importHTML('<h' . $level . '>' . $node['title'] . '</h' . $level . '>');

		$nodeItems = $this->getSortedNodeItems($node);

		foreach($nodeItems as $nodeItem) {
			if(isset($nodeItem['content'])) {
				$nodeItem['content'] = $this->prepareTextForODT($nodeItem['content']);

				$this->openDocument->importHTML($nodeItem['content']);
			} else {
				$this->export_question($nodeItem);
			}
		}

		if(empty($node['ChildNode'])) {
			return true;
		}

		foreach($node['ChildNode'] as $childNode) {
			$this->export_node_to_odt($childNode,$level + 1);
		}

		if($level < 3 && !empty($this->answerKey)) {
			$this->openDocument->importHTML('<h' . ($level + 1) . '>' . __('Answers',true) . '</h' . ($level + 1) . '>');
			$this->openDocument->importHTML($this->answerKey);
			$this->answerKey = '';
		}
	}
}