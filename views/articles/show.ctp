<ul class="articles">
	<? foreach($articles as $article): ?>
		<li>
			<a href="/<?= $group['web_path'] ?>/<?= $course['web_path'] ?>/articles/view/<?= $article['Article']['id'] ?>"><?= $article['Article']['title'] ?></a>
		</li>
	<? endforeach; ?>
</ul>