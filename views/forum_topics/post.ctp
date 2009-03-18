<tbody id="gclms-thread-<?= $id ?>" class="gclms-thread<?= empty($hidden) ? '' : ' gclms-hidden' ?>">
	<tr class="gclms-headers">
		<th colspan="2">
			<div class="gclms-left"><?= $myTime->niceShort($created) ?></div>
		</th>	
	</tr>
	<tr>
		<td class="gclms-profile-column">
			<div>
				<div class="gclms-username"><a href="/user/<?= $username ?>"><?= $username?></a></div>
				<div class="gclms-avatar">
					<img src="http://www.gravatar.com/avatar.php?gravatar_id=<?= md5($email) ?>&default=<?= urlencode(@$default) ?>&size=96" />
				</div>
			</div>
		</td>
		<td class="gclms-forum-post-content">
			<?= nl2br($content) ?>
		</td>
	</tr>
</tbody>