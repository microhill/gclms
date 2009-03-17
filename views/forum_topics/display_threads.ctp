<?
$tmpThreads = Set::extract('/ForumPost[parent_post_id=' . $parent_post_id . ']',$threads);
if(!empty($tmpThreads)): ?>
	<ul>
	<? foreach($tmpThreads as $thread): ?>
		<li>
			<span class="gclms-thread-author"><?= $thread['ForumPost']['User']['username'] ?></span> <a href="<?= $groupAndCoursePath ?>/forum_topics/view/<?= $topic_id ?>#<?= $thread['ForumPost']['id'] ?>" gclms-thread-id="<?= $thread['ForumPost']['id'] ?>"><?= $thread['ForumPost']['title'] ?></a> <?= $myTime->niceShort($thread['ForumPost']['created']) ?>
			<?
			echo $this->element('../forum_topics/display_threads',array(
				'threads' => $threads,
				'topic_id' => $topic_id,
				'parent_post_id' => $thread['ForumPost']['id']
			));
			?>
		</li>
	<? endforeach; ?>
	</ul>
<? endif; ?>