<style>
.gclms-bible-chapter-navigation {
	margin-top: 6px;
}

.gclms-bible-chapter {}

	.gclms-bible-chapter .gclms-bible-verse {
		display: inline;
		line-height: 1.4em;
		margin: 2px;
		padding: 1px;
	}

	.gclms-bible-chapter .gclms-selected {
		background-color: #ffffcc;
	}
	
	.gclms-bible-chapter .gclms-verse-number {
		font-weight: bold;
		font-size: .8em;
		padding-right: 0.15em;
		vertical-align: text-bottom;
		padding-top: 3px;
		padding-bottom: 3px;
	}
	
	.gclms-chapter gclms-verse-text {
		padding: 2px;		
	}
</style>
<div class="gclms-bible-chapter">
	<div class="gclms-step-back"><a href="/<?= $this->params['group'] . '/' . $this->params['course'] ?>/bible_kjv/books"><? __('Back to Old and New Testament books') ?></a></div>
	<h1><?= $book . ' ' . $chapter ?></h1>
	<? foreach($verses as $number => $text): ?>
		<div id="<?= $number + 1 ?>" class="gclms-bible-verse"><span class="gclms-verse-number"><?= $number + 1 ?></span> <span class="gclms-verse-text"><?= $text ?></span></div>
	<? endforeach; ?>
	<div class="gclms-bible-chapter-navigation">
		<a href="/<?= $this->params['group'] . '/' . $this->params['course'] ?>/bible_kjv/lookup/book:<?= $book ?>/chapter:<?= $chapter - 1 ?>" style="float: left;"><img src="/img/icons/crystal_clear/22x22/actions/agt_back.png" /></a>
		<a href="/<?= $this->params['group'] . '/' . $this->params['course'] ?>/bible_kjv/lookup/book:<?= $book ?>/chapter:<?= $chapter + 1 ?>" style="float: right;"><img src="/img/icons/crystal_clear/22x22/actions/agt_forward.png" /></a>
	</div>
</div>
