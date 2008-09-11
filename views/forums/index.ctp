<?
$html->css('forums', null, null, false);

$javascript->link(array(
	'vendors/prototype1.6.0.2',
	'prototype_extensions1.0',
	'gclms'
), false);

echo $this->element('left_column'); ?>
<div class="gclms-center-column">
	<div class="gclms-content">
		<h1><? __('Forums') ?></h1>
		<button href="forums/add">Add Forum</button>
		
		<? if(!empty($this->data)): ?>
			<div class="gclms-records">
				<table class="gclms-tabular">
					<tr class="gclms-headers">
						<th>
							<div class="gclms-left">Forum</div>
						</th>
						<th>
							<div class="gclms-center">Topics</div>
						</th>
						<th class="gclms-center">
							<div class="gclms-center">Posts</div>
						</th>
						<th>
							<div class="gclms-left">Last post</div>
						</th>		
					</tr>
				<? foreach($this->data as $forum): ?>
					<tbody class="gclms-descriptive-recordset">
						<tr href="<?= $groupAndCoursePath ?>/forums/view/<?= $forum['Forum']['id'] . $framed_suffix ?>">
							<td>
								<span class="gclms-forum-title"><?= $forum['Forum']['title'] ?></span>
								<?
								if(!empty($forum['Forum']['title']))
									echo '<br/>' . $forum['Forum']['description'];
								?>
							</td>
							<td class="gclms-topic-count">
								<div class="gclms-center"><?= $forum['Forum']['topic_count'] ?></div>
							</td>
							<td class="gclms-post-count">
								<div class="gclms-center"><?= $forum['Forum']['post_count'] ?></div>
							</td>
							<td class="gclms-last-post">
								<? if(!empty($forum['Forum']['last_post'])): ?>
								 	<?= $myTime->niceShort($forum['Forum']['last_post']['ForumPost']['created']) ?><br/>
								 	<?= $forum['Forum']['last_post']['User']['alias'] ?>
								<? else: ?>
									<br/><br/>
								<? endif; ?>
							</td>		
						</tr>
					</tbody>
				<? endforeach; ?>
				</table>
			</div>
		<? endif; ?>
	</div>
</div>
<?= $this->element('right_column'); ?>