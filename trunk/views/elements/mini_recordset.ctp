<table class="gclms-tabular" cellspacing="0">
	<?
	//$headers = am(array('<img src="/img/icons/add-14.png" class="Add" />'),$headers);
	//echo $html->tableHeaders($headers, array('class'=>'Headers'));
	?>
	<?= $html->tableHeaders(order($headers,$text_direction), array('class'=>'gclms-headers')) ?>
    <tbody class="gclms-recordset">
	    <?
	    foreach ($data as $row) {
		    $cellData = array_intersect_key_and_sort($dataCustomizer($row,$this->loaded), $fields);
		    foreach($cellData as $fieldName => $value) {
		    	if(empty($value))
		    		$cellData[$fieldName] = '&nbsp;';
		    }
		    
	    	echo $html->tableCells(
	    		order($cellData)
	    	);
	    }
	    ?>
    </tbody>
</table>