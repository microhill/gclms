<ul class="gclms-news-items">
<?
$count = 0;
foreach($news_items as $news_item):
?>
	<li>
		<h2><?= $news_item['NewsItem']['title'] ?></h2>
		<p><em><? __('Posted') ?> <?= $myTime->niceShortDate($news_item['NewsItem']['post_date']) ?></em></p>
		<p><?= $news_item['NewsItem']['content'] ?></p>
	</li>
<?
	$count++;
endforeach; 
?>
</ul>