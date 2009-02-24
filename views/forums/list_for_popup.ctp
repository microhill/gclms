<h3>Forums</h3>
<ul>
<?
foreach($forums as $forum): ?>
	<li><a href="#" gclms-forum-id="$forum['Forum']['id']"><?= $forum['Forum']['title'] ?></a><br/>
		<?= $forum['Forum']['description'] ?></li>
<?
endforeach;
?>
</ul>