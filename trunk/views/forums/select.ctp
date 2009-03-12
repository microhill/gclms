<h2>Forums</h2>
<ul>
<?
foreach($forums as $forum): ?>
	<li>
		<div><a href="#" gclms-forum-id="<?= $forum['Forum']['id'] ?>"><?= $forum['Forum']['title'] ?></a></div>
		<div class="gclms-description"><?= $forum['Forum']['description'] ?></div>
	</li>
<?
endforeach;
?>
</ul>