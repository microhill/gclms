<? if(!empty($my_groups)): ?>
	<ul class="gclms-unbulleted-list">
	<?
	foreach($my_groups as $groupWebPath => $groupName) {
		echo '	<li><a href="/' . $groupWebPath . '">' . $groupName . '</a></li>';
	}
	?>
	</ul>
<? endif; ?>