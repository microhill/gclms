<?
$html->css('forum', null, null, false);

$javascript->link(array(
	'vendors/prototype1.6.0.2',
	'vendors/prototype_extensions1.0',
	'gclms'
), false);

echo $this->element('no_column_background'); ?>

<div class="gclms-content">
	<div class="gclms-step-back"><a href="<?= $groupAndCoursePath ?>/forums/view/<?= $this->data['ForumPost']['forum_id'] ?><?= $framed_suffix ?>"><? __('Back to forum') ?></a></div>
	<h1><?= $this->data['ForumPost']['title'] ?></h1>
	
	<button href="<?= $groupAndCoursePath ?>/forum_topics/delete/<?= $this->data['ForumPost']['id'] ?><?= $framed_suffix ?>" gclms:confirm-text="<? __('Are you sure you want to delete this post?') ?>">Delete Topic</button>	

	<div class="gclms-records gclms-forums-posts">
		<table class="gclms-tabular">
			<tr class="gclms-headers">
				<th colspan="2">
					<div class="gclms-left"><?= $myTime->niceShort($this->data['ForumPost']['created']) ?></div>
				</th>	
			</tr>
			<tbody>
				<tr>
					<td width="20%">
						<div>
							<div class="gclms-alias"><?= $this->data['User']['alias'] ?></div>
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
			<tbody>
				<tr class="gclms-headers">
					<th colspan="2">
						<div class="gclms-left"><?= $myTime->niceShort($post['created']) ?></div>
					</th>	
				</tr>
				<tr>
					<td width="20%">
						<div>
							<div class="gclms-alias"><?= $post['User']['alias'] ?></div>
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