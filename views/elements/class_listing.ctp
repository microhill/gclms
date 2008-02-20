<? if(!empty($enrollees)): ?>
	<ul class="gclms-unbulleted-list">
	<?
	foreach($enrollees as $class) {
		echo '	<li><a href="/' . $class['FacilitatedClass']['Course']['Group']['web_path'] . '/' . $class['FacilitatedClass']['Course']['web_path'] . '/' . $class['FacilitatedClass']['id'] . '">' . $class['FacilitatedClass']['Course']['title'] . '</a></li>';
	}
	?>
	</ul>
<? endif; ?>