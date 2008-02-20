<? if(!empty($courses) && !empty($group)): ?>
	<ul class="gclms-unbulleted-list">
	<? foreach($courses as $course): ?>	
		<li><a href="/<?= $group['web_path'] . '/' . $course['Course']['web_path'] ?>"><?= $course['Course']['title'] ?></a></li>
	<? endforeach; ?>
	</ul>
<? endif; ?>