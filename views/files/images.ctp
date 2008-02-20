<?= $this->renderElement('no_column_background'); ?>
<div class="gclms-content">	
	<ul class="files">
	<?
	foreach($files as $file) {
		echo "<li><a href='" . $file['uri'] . "' onclick='return chooseFile(this);'><img src='" . $groupAndCoursePath . "/files/thumbnail/" . $file['basename'] . "' /> " . $file['basename'] . "</a>" . '</li>';		
	}
	?>
	</ul>
</div>