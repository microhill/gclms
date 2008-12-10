<?
if(!empty($courses)): ?>
	<ul class="gclms-unbulleted-list">
	<? foreach($courses as $course){ 
		if($course['Course']['published_status'] == 0) {
			if(Permission::check(array(
				'model' => 'Course',
				'foreign_key' => $course['Course']['id']
			)))				
				continue;
		}

		?>	
		<li><a href="/<?= Group::get('web_path') . '/' . $course['Course']['web_path'] ?>"><?= $course['Course']['title'] ?> <? if($course['Course']['published_status'] == 0) __('(Draft)') ?></a></li>
	<? } ?>
	</ul>
<? endif; ?>