<? if(!empty($groups)): ?>
	<ul class="gclms-unbulleted-list">
	<?
	foreach($groups as $groupWebPath => $groupName) {
		echo '	<li><a href="/' . $groupWebPath . '">' . $groupName . '</a></li>';
	}
	?>
	</ul>
<? endif; ?>