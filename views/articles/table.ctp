<div id="table">
	<?
	$myPaginator->options(array('url' => $groupAndCoursePath . '/articles/index'));

	$headers = array(
		$myPaginator->sort(__('Title',true),'title')
	);
	$fields = array('Article.title');

	function customizeCellData($row,$helpers) {
		return $row;
	}

	function customizeRowURL($row,$url) {
		return $url['groupAndCoursePath'] . '/articles/edit/' . $row['Article']['id'];
	}

	echo $this->renderElement('recordset',array(
		'headers' => $headers,
		'fields' => $fields,
		'heading' => __('Articles', true),
		'data' => $data,
		'addButtonUrl' => $groupAndCoursePath . '/articles/add'
	));
	?>
</div>