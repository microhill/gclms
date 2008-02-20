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

<div id="gclms-spinner"><img src="/img/permanent/spinner2007-09-14.gif"/></div>

<? if(!empty($heading)): ?>
<h1><?= Inflector::humanize(__($heading,true)); ?></h1>
<? endif; ?>

<table class="Records" width="100%">
	<tr class="gclms-menubar">
		<td class="Left">
			<? if(@$showDefaultAddButton): ?>
				<button class="gclms-add" link:href="<?= $defaultAddButtonUri ?>" id="gclmsAdd">
					<img src="/img/permanent/icons/2007-09-13/add-12.png"/>
					<? __(isset($defaultAddButtonTitle) ? $defaultAddButtonTitle : 'Add') ?>
				</button>
			<? endif;
			
			if(isset($buttons))
				echo $buttons;

			?>
		</td>
		<td class="Center"></td>
		<td class="Right Search"><!-- input type="text"/--></td>
	</tr>
	<tr>
		<td  colspan="3">
			<? if(!empty($data)): ?>
			<table class="gclms-tabular" cellspacing="0">
				<?= $html->tableHeaders(order($headers), array('class'=>'Headers')) ?>
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
				    		order($cellData)
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