<div class="gclms-buttons">
	<? foreach($buttons as $button): ?>
		<table class="gclms-button gclms-hover-<?= empty($button['hover_color']) ? 'grey' : $button['hover_color'] ?> <?= @$button['class'] ?>"
			<?
			if(!empty($button['phrases']))
				foreach($button['phrases'] as $attribute => $phrase) {
					echo $attribute . '="' . $phrase . '"';
				}
			?>
			>
			<tr>
				<td>
					<div class="gclms-top">
						<b class="gclms-row"></b>
					</div>
					<div class="gclms-contain"><?= $button['text'] ?></div>
					<div class="gclms-bottom">
						<b class="gclms-row"></b>
					</div>
				</td>
			</tr>
		</table>
	<? endforeach; ?>
</div>