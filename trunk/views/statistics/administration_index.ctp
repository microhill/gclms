<?
echo $this->element('left_column'); ?>
		
<div class="gclms-center-column">
	<div class="gclms-content">
		<h1><? __('Statistics') ?></h1>
	
		<p><?= sprintf('This site has a total of %s groups, %s courses, and %s users.',$group_count,$course_count,$user_count) ?></p>
		
		<h2>New Pages</h2>
		<p><img src="http://chart.apis.google.com/chart?cht=lc&chds=<?= min($pages_created) ?>,<?= max($pages_created) ?>&chf=bg,s,f6f6f6&chd=t:<?= implode(',',$pages_created) ?>&chs=600x200" /></p>
		
		<h2>New Users</h2>
		<p><img src="http://chart.apis.google.com/chart?cht=lc&chds=<?= min($users_created) ?>,<?= max($users_created) ?>&chf=bg,s,f6f6f6&chd=t:<?= implode(',',$users_created) ?>&chs=600x200" /></p>
		
		<h2>Forum Posts</h2>
		<p><img src="http://chart.apis.google.com/chart?cht=lc&chds=<?= min($forum_posts_created) ?>,<?= max($forum_posts_created) ?>&chf=bg,s,f6f6f6&chd=t:<?= implode(',',$forum_posts_created) ?>&chs=600x200" /></p>
	</div>
</div>

<?= $this->element('right_column'); ?>