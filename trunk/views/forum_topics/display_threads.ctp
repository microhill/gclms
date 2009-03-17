<ul>
<? foreach($threads as $thread): ?>
	<li>
		<span class="gclms-thread-author"><?= $thread['User']['username'] ?></span> <a href="<?= $groupAndCoursePath ?>/forum_topics/view/<?= $topic_id ?>#<?= $thread['id'] ?>"><?= $thread['title'] ?></a> <?= $myTime->niceShort($thread['created']) ?>
	</li>
<? endforeach; ?>
<ul>