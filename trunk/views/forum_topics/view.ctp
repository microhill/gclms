<?
$html->css('forum', null, null, false);

$javascript->link(array(
	'vendors/prototype1.6.0.3',
	'vendors/prototype_extensions1.0',
	'gclms',
	'forum_topic'
), false);

?>

<div class="gclms-content">
	<div class="gclms-step-back"><a href="<?= $groupAndCoursePath ?>/forums/view/<?= $this->data['ForumPost']['forum_id'] ?>"><? __('Back to forum') ?></a></div>
	<h1><?= $this->data['ForumPost']['title'] ?></h1>
	
	<button href="<?= $groupAndCoursePath ?>/forum_topics/delete/<?= $this->data['ForumPost']['id'] ?>" gclms:confirm-text="<? __('Are you sure you want to delete this post?') ?>">Delete Topic</button>	

	<div id="gclms-thread-listing">
		<table class="gclms-tabular">
			<tr class="gclms-headers">
				<th>
					<? __('Threads') ?>
				</th>
			</tr>
			<tr>
				<td>
					<ul>
						<li>
							<span class="gclms-thread-author"><?= $this->data['User']['username'] ?></span> <a href="#"><?= $this->data['ForumPost']['title'] ?></a> <?= $myTime->niceShort($this->data['ForumPost']['created']) ?>
							<?
							echo $this->element('../forum_topics/display_threads',array(
								'threads' => array('ForumPost' => $this->data['Reply']),
								'topic_id' => $this->data['ForumPost']['id'],
								'parent_post_id' => $this->data['ForumPost']['id']
							))
							?>	
						</li>
					</ul>
				</td>
			</tr>
		</table>
	</div>

	<div id="gclms-threads" class="gclms-records gclms-forums-posts">
		<table class="gclms-tabular">
			<tbody id="gclms-thread-<?= $this->data['ForumPost']['id'] ?>" class="gclms-thread">
				<tr class="gclms-headers">
					<th colspan="2">
						<div class="gclms-left"><?= $myTime->niceShort($this->data['ForumPost']['created']) ?></div>
					</th>	
				</tr>
				<tr>
					<td width="20%">
						<div>
							<div class="gclms-username"><?= $this->data['User']['username'] ?></div>
							<div class="gclms-avatar">
								<img src="http://www.gravatar.com/avatar.php?gravatar_id=<?= md5($this->data['User']['email']) ?>&default=<?= urlencode(@$default) ?>&size=96" />
							</div>
						</div>
					</td>
					<td class="gclms-forum-post-content">
						<?= nl2br($this->data['ForumPost']['content']) ?>
					</td>
				</tr>
			</tbody>
		<? foreach($this->data['Reply'] as $post): ?>
			<tbody id="gclms-thread-<?= $post['id'] ?>" class="gclms-thread gclms-hidden">
				<tr class="gclms-headers">
					<th colspan="2">
						<div class="gclms-left"><?= $myTime->niceShort($post['created']) ?></div>
					</th>	
				</tr>
				<tr>
					<td width="20%">
						<div>
							<div class="gclms-username"><?= $post['User']['username'] ?></div>
							<div class="gclms-avatar">
								<img src="http://www.gravatar.com/avatar.php?gravatar_id=<?= md5($post['User']['email']) ?>&default=<?= urlencode(@$default) ?>&size=96" />
							</div>
						</div>
					</td>
					<td class="gclms-forum-post-content">
						<?= nl2br($post['content']) ?>
					</td>
				</tr>
			</tbody>
		<? endforeach; ?>
		</table>
	</div>
	
	<!-- div class="gclms-buttons">
		<table>
			<tr>
				<td><a href="<?= $groupAndCoursePath ?>/forums/reply">Post Reply</a></td>
			</tr>
		</table>
	</div -->
	
	<div id="gclms-forums-reply">
		<?
		echo $form->create('Reply', array('url'=>$groupAndCoursePath . '/forum_topics/view/' . $this->data['ForumPost']['id'] . $framed_suffix));
		echo $form->hidden('parent_post_id',array(
			'value' => $this->data['ForumPost']['id']
		));
		echo $form->input('content',array(
			'label' => __('Reply',true),
			'between' => '<br/>',
			'rows' => 19,
			'cols' => 80
		));
		echo $form->submit(__('Post',true),array('class'=>'gclms-save'));
		echo $form->end();
		?>
	</div>		
</div>