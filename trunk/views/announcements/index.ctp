<?
$javascript->link(array(
	'vendors/prototype',
	'prototype_extensions',
	'gclms'
), false);

echo $this->renderElement('left_column'); ?>
	
<div class="gclms-center-column">
	<div class="gclms-content">	
		<div id="table">
			<?
			//$myPaginator->options(array('url'=>array('group'=>$group['web_path'],'courses'=>null)));	
			
			$headers = array(
				$myPaginator->sort(__('Title',true),'title'),
				$myPaginator->sort(__('Post date',true),'post_date')
			);
			$fields = array('NewsItem.title','NewsItem.post_date');
			
			function customizeCellData($row,$helpers) {
				$row['NewsItem']['post_date'] = $helpers['myTime']->niceShortDate($row['NewsItem']['post_date']);
				return $row;
			}
			
			function customizeRowURL($row,$url) {
				return '/' . $url['group'] . '/announcements/view/' . $row['NewsItem']['id'] . '/course:' . $url['course'] . '/section:' . $url['section'];
			}
			
			echo $this->renderElement('recordset',array(
				'headers' => $headers,
				'fields' => $fields,
				'heading' => 'Class Announcements',
				'data' => $data,
				'addButtonUrl' => '/' . $group['web_path'] . '/announcements/add/course:' . $course['web_path'] . '/section:' . $facilitated_class['id']
			));
			?>
		</div>
	</div>
</div>

<?= $this->renderElement('right_column'); ?>