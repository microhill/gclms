<?
$javascript->link(array(
	'vendors/prototype',
	'prototype_extensions',
	'gclms'
), false);

echo $this->element('no_column_background'); ?>

<div class="gclms-center-column">
	<div class="gclms-content">
		<div class="gclms-step-back"><a href="<?= $groupAndCoursePath ?>/forums/view/<?= $this->data['ForumPost']['forum_id'] ?>"><? __('Back to forum') ?></a></div>
		<h1><?= $this->data['ForumPost']['title'] ?></h1>

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
								<?= $this->data['User']['alias'] ?>
								<p>
									<img src="http://www.gravatar.com/avatar.php?gravatar_id=<?= md5($this->data['User']['email']) ?>"&default="<?= urlencode(@$default) ?>&size=40" />
								</p>
							</div>
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
								<div><?= $this->data['User']['alias'] ?></div>
							</td>
							<td>
								<div><?= nl2br($this->data['FormPost']['content']) ?></div>
							</td>
						</tr>
					</tbody>
				</table>
			<? endforeach; ?>
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
			echo $form->create('Reply', array('url'=>$groupAndCoursePath . '/forums/reply/topic:' . $this->data['ForumPost']['id']));
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
</div>