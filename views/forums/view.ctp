<?
$html->css('forums', null, null, false);

$javascript->link(array(
	'vendors/prototype',
	'prototype_extensions',
	'gclms'
), false);

echo $this->element('no_column_background'); ?>

<div class="gclms-center-column">
	<div class="gclms-content">
		<div class="gclms-step-back"><a href="<?= $groupAndCoursePath ?>/forums"><? __('Back to forums') ?></a></div>
		
		<h1><?= $forum['Forum']['title'] ?></h1>
		
		<table class="gclms-buttons">
			<tr>
				<td>
					<button href="<?= $groupAndCoursePath ?>/forum_topics/add/forum:<?= $forum['Forum']['id'] ?>">New Topic</button>
				</td>
				<td>
					<button href="<?= $groupAndCoursePath ?>/forums/delete/<?= $forum['Forum']['id'] ?>" gclms:confirm-text="<? __('Are you sure you want to delete this forum?') ?>">Delete Forum</button>
				</td>
			</tr>
		</table>
		
		<div class="gclms-records">
			<table class="gclms-tabular">
				<tr class="gclms-headers">
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
					<tr href="<?= $groupAndCoursePath ?>/forum_topics/view/<?= $post['ForumPost']['id'] ?>">
						<td>
							<span class="gclms-forum-post-title"><?= $post['ForumPost']['title'] ?></span>
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
	</div>
</div>