<h1><? __('Articles') ?></h1>
<ul>
	<? foreach($articles as $article): ?>
	<li><a href="<?= $groupAndCoursePath ?>/articles/view/<?= $article['Article']['id'] ?>"><?= $article['Article']['title'] ?></a></li>
	<? endforeach; ?>
</ul>
