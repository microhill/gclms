<h2>Forums</h2>
<ul>
<?
foreach($forums as $forum): ?>
	<li><a href="#" gclms-forum-id="$forum['Forum']['id']"><?= $forum['Forum']['title'] ?></a><br/>
		<?= $forum['Forum']['description'] ?></li>
<?
endforeach;
?>
</ul>