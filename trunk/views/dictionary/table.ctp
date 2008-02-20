<div id="table">
	<?
	$myPaginator->options(array('url' => $groupAndCoursePath . '/dictionary/index'));

	$headers = array(
		$myPaginator->sort(__('Term',true),'DictionaryTerm.term')
	);
	$fields = array('DictionaryTerm.term');

	function customizeCellData($row,$helpers) {
		return $row;
	}

	function customizeRowURL($row,$url) {
		return $url['groupAndCoursePath'] . '/dictionary/edit/' . $row['DictionaryTerm']['id'];
	}

	echo $this->renderElement('recordset',array(
		'headers' => $headers,
		'fields' => $fields,
		'heading' => __('Dictionary Terms', true),
		'data' => $data,
		'addButtonUrl' => $groupAndCoursePath . '/dictionary/add'
	));
	?>
</div>