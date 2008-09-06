<?
$javascript->link(array(
	'vendors/prototype',
	'prototype_extensions',
	'gclms'
), false);
echo $this->element('left_column'); ?>
<div class="gclms-center-column">
	<div class="gclms-content">
		<h1><? __('Forums') ?></h1>
		<button href="forums/add_forum">Add Forum</button>
		
		<div class="Records">
			<table class="gclms-tabular">
				<tr class="Headers">
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
					<tr>
						<td>
							<span class="gclms-forum-title"><a href="<?= $groupAndCoursePath ?>/forums/forum/<?= $forum['Forum']['id'] ?>"><?= $forum['Forum']['title'] ?></a></span>
							<?
							if(!empty($forum['Forum']['title']))
								echo '<br/>' . $forum['Forum']['description'];
							?>
						</td>
						<td>
							<div class="gclms-center"><?= @$forum['Forum']['total_topics'] ?></div>
						</td>
						<td>
							<div class="gclms-center"><?= @$forum['Forum']['total_posts'] ?></div>
						</td>
						<td>
						 	<?= @$forum['Forum']['last_post_timestamp'] ?><br/>
						 	<?= @$forum['Forum']['last_post_username'] ?>
						</td>		
					</tr>
				</tbody>
			<? endforeach; ?>
			</table>
		</div>
	</div>
</div>
<?= $this->element('right_column'); ?>