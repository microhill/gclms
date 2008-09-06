<?
$javascript->link(array(
	'vendors/prototype',
	'prototype_extensions',
	'gclms'
), false);
?>
<div class="gclms-step-back"><a href="<?= $groupAndCoursePath ?>/forums"><? __('Back to list of forums') ?></a></div>

<h1><?= $forum['Forum']['title'] ?></h1>

<div class="gclms-buttons">
	<table>
		<tr>
			<td><a href="<?= $groupAndCoursePath ?>/forums/add_topic/forum:<?= $forum['Forum']['id'] ?>">New Topic</a></td>
			<td><a href="<?= $groupAndCoursePath ?>/forums/delete_forum/<?= $forum['Forum']['id'] ?>">Delete Forum</a></td>
		</tr>
	</table>
</div>

<div class="Records">
	<table class="gclms-tabular">
		<tr class="Headers">
			<th>
				<div class="gclms-left">Topics</div>
			</th>
			<th>
				<div class="gclms-center">Replies</div>
			</th>
			<th class="gclms-center">
				<div class="gclms-center">Author</div>
			</th>
			<th>
				<div class="gclms-left">Last post</div>
			</th>		
		</tr>
	<? foreach($this->data as $post): ?>
		<tbody class="gclms-descriptive-recordset">
			<tr>
				<td>
					<span class="gclms-forum-post-title"><a href="<?= $groupAndCoursePath ?>/forums/topic/<?= $post['ForumPost']['id'] ?>"><?= $post['ForumPost']['title'] ?></a></span>
					<?
					if(!empty($forum['ForumPost']['title']))
						echo '<br/>' . $post['ForumPost']['description'];
					?>
				</td>
				<td>
					<div class="gclms-center"><?= @$post['ForumPost']['total_replies'] ?></div>
				</td>
				<td>
					<div class="gclms-center"><?= @$post['User']['username'] ?></div>
				</td>
				<td>
				 	<?= @$post['ForumPost']['last_post_timestamp'] ?><br/>
				 	<?= @$post['ForumPost']['last_post_username'] ?>
				</td>		
			</tr>
		</tbody>
	<? endforeach; ?>
	</table>
</div>