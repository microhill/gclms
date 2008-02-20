<?= $this->renderElement('left_column'); ?>

<div class="gclms-center-column">
	<div class="gclms-content">
		<div id="table">
			<?
			$headers = array(
				__('Item', true), __('Grade', true)
			);
			$fields = array('Grade.title','Grade.grade');
			
			function customizeCellData($row,$helpers) {
				$row['Grade']['title'] = $row['Page']['title'];
				$row['Grade']['grade'] = $row['Grade']['grade'] . ' / ' . $row['Grade']['maximum_possible'];
				return $row;
			}
			
			echo $this->renderElement('recordset',array(
				'headers' => $headers,
				'fields' => $fields,
				'heading' => __('Your Grades', true),
				'showDefaultAddButton' => false,
				'addButtonUrl' => '/' . $group['web_path'] . '/facilitated_classes/add'
			));
			?>
		</div>
	</div>
</div>

<?= $this->renderElement('right_column'); ?>

