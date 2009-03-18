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
							<span class="gclms-thread-author"><?= $this->data['User']['username'] ?></span> <a href="#" gclms-thread-id="<?= $this->data['ForumPost']['id'] ?>"><?= $this->data['ForumPost']['title'] ?></a> <?= $myTime->niceShort($this->data['ForumPost']['created']) ?>
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
			<?= $this->element('../forum_topics/post',array(
				'id' => $this->data['ForumPost']['id'],
				'created' => $this->data['ForumPost']['created'],
				'content' => $this->data['ForumPost']['content'],
				'username' => $this->data['User']['username'],
				'email' => $this->data['User']['email'],
				'hidden' => false
			)); ?>
		<? foreach($this->data['Reply'] as $post): ?>
			<?= $this->element('../forum_topics/post',array(
				'id' => $post['id'],
				'created' => $post['created'],
				'content' => $post['content'],
				'username' => $post['User']['username'],
				'email' => $post['User']['email'],
				'hidden' => true
			)); ?>
		<? endforeach; ?>
		</table>
	</div>
	
	<div id="gclms-reply">
		<table class="gclms-tabular">
			<tr class="gclms-headers">
				<th><? __('Reply') ?></th>
			</tr>
			<tr>
				<td>
					<?
					echo $form->create('Reply', array('url'=>$groupAndCoursePath . '/forum_topics/view/' . $this->data['ForumPost']['id'] . $framed_suffix));
					echo $form->hidden('parent_post_id',array(
						'value' => $this->data['ForumPost']['id']
					));
					echo $form->input('content',array(
						'label' => false,
						'rows' => 19,
						'cols' => 80
					));
					echo $form->submit(__('Post',true),array('class'=>'gclms-save'));
					echo $form->end();
					?>
				</td>
			</tr>
		</table>
	</div>		
</div>