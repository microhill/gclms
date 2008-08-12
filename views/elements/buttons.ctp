<div class="gclms-buttons">
	<? foreach($buttons as $button): ?>
		<table class="gclms-button gclms-hover-<?= empty($button['hover_color']) ? 'grey' : $button['hover_color'] ?> <?= @$button['class'] ?>"
			<?
			if(!empty($button['id']))
				echo 'id="' . $button['id'] . '"';
			
			if(!empty($button['phrases']))
				$button['attributes'] = $button['phrases'];
				
			if(!empty($button['strings']))
				$button['attributes'] = $button['strings'];
			
			if(!empty($button['attributes']))
				foreach($button['attributes'] as $attribute => $phrase) {
					echo $attribute . '="' . $phrase . '"';
				}
			?>>
			<tbody>
				<tr>
					<td>
						<div class="gclms-top">
							<b class="gclms-row"></b>
						</div>
						<div class="gclms-contain"><a href="<?= empty($button['href']) ? '#' : $button['href'] ?>"><?= $button['text'] ?></a></div>
						<div class="gclms-bottom">
							<b class="gclms-row"></b>
						</div>
					</td>
				</tr>
			</tbody>
		</table>
	<? endforeach; ?>
</div>