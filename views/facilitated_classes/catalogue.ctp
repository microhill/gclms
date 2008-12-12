<?= $this->element('left_column'); ?>

<div class="gclms-center-column">
	<div class="gclms-content">
		<?
		$headers = array(
			//$myPaginator->sort(__('Username',true),'username')
			__('Group', true),
			__('Courses', true),
			__('Facilitation', true)
			
		);
		$fields = array('Group.name','Course.name','Course.type');
		
		function customizeCellData($row,$helpers) {
			if(empty($row['Course']['type']))
				$row['Course']['type'] = 'Online';
			else
				$row['Course']['type'] = 'In-person';
			return $row;
		}
		
		function customizeRowURL($row,$defaultUrl) {
			$url = '/' . $row['Group']['web_path'] . '/course:' . $row['Course']['web_path'];
			return $url;
		}
		
		echo $this->element('recordset',array(
			'headers' => $headers,
			'fields' => $fields,
			'showDefaultAddButton' => false,
			'heading' => __('Course Catalogue',true)
		));
		?>
	</div>
</div>

<?= $this->element('right_column'); ?>