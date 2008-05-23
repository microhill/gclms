<?
/**
 * RecordSet control
 *
 * @param string $heading
 * @param array $data
 * @param array $showDefaultAddButton
 * @param array $addButtonUrl
 * @param array $defaultAddButtonTitle
 * @param array $buttons
 *
 * Customizing functions
 * 
 * customizeCellData
 * customizeRowURL
 *
 */
if(!isset($modelName))
	$modelName = $this->params['models'][0];

$adminParam = isset($this->params[Configure::read('Routing.admin')]) ? Configure::read('Routing.admin') : null;

if(!isset($heading) && !empty($heading)) {
	$heading = $this->viewPath;
}
	
if(@$showDefaultAddButton) {
	$defaultAddButtonUri = !empty($addButtonUrl) ? $addButtonUrl : Router::url(array($adminParam=>$adminParam,'action'=>'add','group'=>@$groupWebPath));
}
?>

<? if(!empty($heading)): ?>
<h1><?= Inflector::humanize(__($heading,true)); ?></h1>
<? endif; ?>

<? if(@$showDefaultAddButton) {

	echo $this->element('menubar',array('buttons' => array(
		array(
			'id' => 'gclms-add',
			'class' => 'gclms-add',
			'label' => 'Add',
			'strings' => array(
				'link:href' => $defaultAddButtonUri
			),
			'accesskey' => 'a'
	))));
}
?>

<table class="gclms-records" width="100%">
	<!-- tr class="gclms-menubar">
		<td class="gclms-left">
			<? if(@$showDefaultAddButton): ?>
				<button class="gclms-add" link:href="<?= $defaultAddButtonUri ?>" id="gclmsAdd">
					<? __(isset($defaultAddButtonTitle) ? $defaultAddButtonTitle : 'gclms-add') ?>
				</button>
			<? endif;
			
			if(isset($buttons))
				echo $buttons;

			?>
		</td>
		<td class="Center"></td>
		<td class="Right Search"><!-- input type="text"/--></td>
	</tr -->
	<tr>
		<td  colspan="3">
			<? if(!empty($data)): ?>
			<table class="gclms-tabular" cellspacing="0">
				<?= $html->tableHeaders(order($headers,$text_direction), array('class'=>'Headers')) ?>
			    <tbody class="gclms-recordset">
				    <?
				    foreach ($data as $row) {
					    $cellData = array_intersect_key_and_sort(customizeCellData($row,$this->loaded), $fields);
					    $defaultUrl = array(
							'groupAndCoursePath'=>$groupAndCoursePath,
							'group'=>@$group,
							'course'=>@$course,
							'lesson'=>@$lessonOrder,
							'action'=>'view',
							'id'=>$row[$modelName]['id'],
							'section'=>@$facilitated_class['id']);
					    if(function_exists('customizeRowURL'))
							$link = customizeRowURL($row,$defaultUrl);
					    else
						    $link = Router::url($defaultUrl);
						$firstValue = true;
						foreach($cellData as $fieldName => $value) {
					    	if(empty($value))
					    		$cellData[$fieldName] = '&nbsp;';
							if($firstValue)
							    $cellData[$fieldName] = '<a href="' . $link . '">' . $cellData[$fieldName] . '</a>';
							$firstValue = false;
					    }
				    	echo $html->tableCells(
				    		order($cellData,$text_direction)
				    	);
				    }
				    ?>
			    </tbody>
			</table>
			<? endif; ?>
		</td>
	</tr>
<? if(!empty($data) && !empty($myPaginator->__defaultModel)): ?>
	<tr class="gclms-pagination">
		<td class="gclms-left"><?= $myPaginator->prev('Previous Page'); ?></td>
		<td class="gclms-center">
			<?
			$currentPage = $myPaginator->counter();
			if($currentPage != '1 of 1')
				echo implode('',order(array(__('Page',true),' ',$currentPage)));
			?>
		</td>
		<td class="gclms-right"><?= $myPaginator->next('Next Page'); ?></td>
	</tr>
<? endif; ?>
</table>