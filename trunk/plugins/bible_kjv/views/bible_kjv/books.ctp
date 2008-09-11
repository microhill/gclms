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

<div class="gclms-bible">
	<h2><? __('Old Testament') ?></h2>
	<ul>
		<?
		$prefix = '/' . $this->params['group'] . '/' . $this->params['course'] . '/bible_kjv/';
		
		foreach($old_testament_books as $name => $chapterCount): ?>
			<li>
				<a href="<?= $prefix . 'lookup/book:' . $name . '/chapter:1' ?>" class="<? if($chapterCount > 1) echo 'expandableBibleBook'; ?>"><?= $name ?></a>
				<span class="gclms-chapters hidden"><?
				for($chapter = 1; $chapter <= $chapterCount; $chapter++) {
					echo '<a href="' . $prefix . 'lookup/book:' . $name . '/chapter:' . $chapter . '">' . $chapter . '</a>';
					if($chapter < $chapterCount)
						echo ', ';	
				}
				?></span>
			</li>
		<? endforeach; ?>
	</ul>
	
	<h2><? __('New Testament') ?></h2>
	<ul>
		<?
		foreach($new_testament_books as $name => $chapterCount): ?>
			<li>
				<a href="<?= $prefix . 'lookup/book:' . $name . '/chapter:1' ?>" class="<? if($chapterCount > 1) echo 'expandableBibleBook'; ?>"><?= $name ?></a>
				<span class="gclms-chapters hidden"><?
				for($chapter = 1; $chapter <= $chapterCount; $chapter++) {
					echo '<a href="' . $prefix . 'lookup/book:' . $name . '/chapter:' . $chapter . '">' . $chapter . '</a>';
					if($chapter < $chapterCount)
						echo ', ';	
				}
				?></span>
			</li>
		<? endforeach; ?>
	</ul>
</div>
<?
$javascript->link('vendors/prototype1.6.0.2', false);
$javascript->link('prototype_extensions', false);
$javascript->link('bible', false);
?>