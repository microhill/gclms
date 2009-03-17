<?
$html->css('forums', null, null, false);

$javascript->link(array(
	'vendors/prototype1.6.0.3',
	'vendors/prototype_extensions1.0',
	'gclms',
	'forums'
), false);

?>

<div class="gclms-content">
	<div class="gclms-step-back"><a href="<?= $groupAndCoursePath ?>/forums"><? __('Back to forums') ?></a></div>
	
	<h1><?= $forum['Forum']['title'] ?></h1>
	
	<table class="gclms-buttons">
		<tr>
			<? if($forum['Forum']['type'] != 0): ?>
			<td>
				<button href="<?= $groupAndCoursePath ?>/forum_topics/add/forum:<?= $forum['Forum']['id'] ?>">New Topic</button>
			</td>
			<? endif; ?>
			<td>
				<button href="<?= $groupAndCoursePath ?>/forums/delete/<?= $forum['Forum']['id'] ?>" gclms:confirm-text="<? __('Are you sure you want to delete this forum?') ?>">Delete Forum</button>
			</td>
		</tr>
	</table>
	
	<? if(!empty($this->data)): ?>
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
						<div class="gclms-left">Last reply</div>
					</th>		
				</tr>
			<?
			 foreach($this->data as $post): ?>
				<tbody class="gclms-descriptive-recordset">
					<tr href="<?= $groupAndCoursePath ?>/forum_topics/view/<?= $post['ForumPost']['id'] ?>">
						<td>
							<span class="gclms-forum-post-title"><?= $post['ForumPost']['title'] ?></span>
							<?
							if(!empty($forum['ForumPost']['title']))
								echo '<br/>' . $post['ForumPost']['description'];
							?>
						</td>
						<td class="gclms-replies">
							<div class="gclms-center"><?= @$post['ForumPost']['reply_count'] ?></div>
						</td>
						<td class="gclms-author">
							<div class="gclms-center"><a href="/users/<?= $post['User']['id'] ?>"><?= $post['User']['username'] ?></a></div>
						</td>
						<td class="gclms-last-reply">
							<? if(!empty($post['ForumPost']['last_post']) && $post['ForumPost']['last_post']['ForumPost']['id'] != $post['ForumPost']['id']): ?>
							 	<?= $myTime->niceShort($post['ForumPost']['last_post']['ForumPost']['created']) ?><br/>
							 	<?= $post['ForumPost']['last_post']['User']['username'] ?>
							<? else: ?>
								<br/><br/>
							<? endif; ?>
						</td>		
					</tr>
				</tbody>
			<? endforeach; ?>
			</table>
		</div>
	<? else: ?>
		<p><? __('No topics yet.'); ?></p>
	<? endif; ?>
</div>