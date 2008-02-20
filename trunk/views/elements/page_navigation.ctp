<?
if(!empty($facilitated_class))
	$sectionUriComponent = '/section:' . $facilitated_class['id'];
else
	$sectionUriComponent = '';
?>
<div id="gclms-page-navigation">
	<? if(!empty($page['Page']['previous_page_id'])): ?>
		<a class="gclms-back" href="/<?= $group['web_path'] ?>/<?= $course['web_path'] ?>/classroom/page/<?= $page['Page']['previous_page_id'] ?>">
			<img src="/img/permanent/icons/2007-09-13/back-32.png" alt="<? __('Previous page') ?>" />
		</a>
	<? endif; ?>

	<? if(!empty($page['Page']['next_page_id'])): ?>
		<a class="gclms-next" href="/<?= $group['web_path'] ?>/<?= $course['web_path'] ?>/classroom/page/<?= $page['Page']['next_page_id'] ?>">
			<img src="/img/permanent/icons/2007-09-13/forward-32.png" alt="<? __('Next page') ?>" />
		</a>
	<? endif; ?>
</div>