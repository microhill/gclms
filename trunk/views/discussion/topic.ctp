<?
$javascript->link(array(
	'vendors/prototype',
	'prototype_extensions',
	'gclms'
), false);
?>
<div class="gclms-step-back"><a href="<?= $groupAndCoursePath ?>/discussion/forum/<?= $this->data['ForumPost']['forum_id'] ?>"><? __('Back to forum') ?></a></div>

<h1><?= $this->data['ForumPost']['title'] ?></h1>

<div class="Records gclms-discussion-posts">
	<table class="gclms-tabular">
		<tr class="Headers">
			<th colspan="2">
				<div class="gclms-left"><?= $myTime->niceShort($this->data['ForumPost']['created']) ?></div>
			</th>	
		</tr>
		<tbody>
			<tr>
				<td width="20%">
					<div><?= $this->data['User']['username'] ?></div>
				</td>
				<td>
					<div><?= nl2br($this->data['ForumPost']['content']) ?></div>
				</td>
			</tr>
		</tbody>
	</table>
	<? foreach($this->data['Reply'] as $post): ?>
		<table class="gclms-tabular">
			<tr class="Headers">
				<th colspan="2">
					<div class="gclms-left"><?= $myTime->niceShort($post['created']) ?></div>
				</th>	
			</tr>
			<tbody>
				<tr>
					<td width="20%">
						<div><?= $post['User']['username'] ?></div>
					</td>
					<td>
						<div><?= nl2br($post['content']) ?></div>
					</td>
				</tr>
			</tbody>
		</table>
	<? endforeach; ?>
</div>

<!-- div class="gclms-buttons">
	<table>
		<tr>
			<td><a href="<?= $groupAndCoursePath ?>/discussion/reply">Post Reply</a></td>
		</tr>
	</table>
</div -->

<div id="gclms-discussion-reply">
	<?
	echo $form->create('Reply', array('url'=>$groupAndCoursePath . '/discussion/reply/topic:' . $this->data['ForumPost']['id']));
	echo $form->input('content',array(
		'label' => __('Reply',true),
		'between' => '<br/>',
		'rows' => 19,
		'cols' => 80
	));
	echo $form->submit(__('Post',true),array('class'=>'Save'));
	echo $form->end();
	?>
</div>