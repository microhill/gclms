<? if(!empty($courses) && !empty($group)): ?>
	<ul class="gclms-unbulleted-list">
	<? foreach($courses as $course): ?>	
		<li><a href="/<?= $group['web_path'] . '/' . $course['Course']['web_path'] ?>"><?= $course['Course']['title'] ?> <? if($course['Course']['published_status'] == 0) __('(Draft)') ?></a></li>
	<? endforeach; ?>
	</ul>
<? endif; ?>