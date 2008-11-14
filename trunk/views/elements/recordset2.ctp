<?
/**
 * RecordSet control
 *
 * @param string $heading
 * @param array $data
 *
 */
if(!isset($modelName))
	$modelName = $this->params['models'][0];
?>
<table class="gclms-records" width="100%">
	<tr>
		<td  colspan="3">
			<? if(!empty($records)): ?>
			<table class="gclms-tabular gclms-hover-rows" cellspacing="0">
				<?= $html->tableHeaders(order($headers,$text_direction), array('class'=>'Headers')) ?>
			    <tbody class="gclms-recordset">
				    <?
				    foreach ($records as $row) {
				    	if(function_exists(@$cell_customizer))
						    $cellData = array_intersect_key_and_sort($cell_customizer($row,$this->loaded), $fields);
						else	
						    $cellData = array_intersect_key_and_sort($row, $fields);
					    $defaultUrl = array(
							'groupAndCoursePath'=>$groupAndCoursePath,
							'action'=>'view',
							'id'=>$row[$modelName]['id'],
							'section'=>@$virtual_class['id']);
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
<? if(!empty($records) && !empty($myPaginator->__defaultModel)): ?>
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