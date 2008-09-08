<?
echo $this->element('left_column'); ?>
		
<div class="gclms-center-column">
	<div class="gclms-content">
		<h1><? __('Statistics') ?></h1>
		
		<?
		$date_range = implode('|',array(
			date('M j',strtotime('31 days ago')),
			date('M j',strtotime('21 days ago')),
			date('M j',strtotime('11 days ago')),
			date('M j',strtotime('1 days ago'))
		));
		?>
	
		<p><?= sprintf('This site has a total of %s groups, %s courses, and %s users.',$group_count,$course_count,$user_count) ?></p>
		
		<h2>New Pages</h2>
		<? if(!empty(max($pages_created))): ?>
		<p><img src="http://chart.apis.google.com/chart?cht=lc&chxl=0:1|2&chxl=0:|<?= $date_range ?>|1:|0|<?= max($pages_created) ?>&chxt=x,y&chds=<?= min($pages_created) ?>,<?= max($pages_created) ?>&chf=bg,s,f6f6f6&chd=t:<?= implode(',',$pages_created) ?>&chs=600x200" /></p>
		<? else: ?>
		<p><? __('No activity in the past 31 days.') ?></p>
		<? endif; ?>
		
		<h2>New Users</h2>
		<? if(!empty(max($users_created))): ?>
		<p><img src="http://chart.apis.google.com/chart?cht=lc&chxl=0:1|2&chxl=0:|<?= $date_range ?>|1:|0|<?= max($users_created) ?>&chxt=x,y&chds=<?= min($users_created) ?>,<?= max($users_created) ?>&chf=bg,s,f6f6f6&chd=t:<?= implode(',',$users_created) ?>&chs=600x200" /></p>
		<? else: ?>
		<p><? __('No activity in the past 31 days.') ?></p>
		<? endif; ?>
		
		<h2>Forum Posts</h2>
		<? if(!empty(max($forum_posts_created))): ?>
		<p><img src="http://chart.apis.google.com/chart?cht=lc&chxl=0:1|2&chxl=0:|<?= $date_range ?>|1:|0|<?= max($forum_posts_created) ?>&chxt=x,y&chds=<?= min($forum_posts_created) ?>,<?= max($forum_posts_created) ?>&chf=bg,s,f6f6f6&chd=t:<?= implode(',',$forum_posts_created) ?>&chs=600x200" /></p>
		<? else: ?>
		<p><? __('No activity in the past 31 days.') ?></p>
		<? endif; ?>
	</div>
</div>

<?= $this->element('right_column'); ?>