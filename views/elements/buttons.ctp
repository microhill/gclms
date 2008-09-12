<table class="gclms-buttons">
	<tbody>
		<tr>
			<? foreach($buttons as $button): ?>
				<td>
					<button class="<?= @$button['class'] ?>"
					<?
					if(!empty($button['href']))
						echo 'href="' . $button['href'] . '"';
						
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
					?>
					><?= $button['text'] ?></button>
				</td>
			<? endforeach; ?>
		</tr>
	</tbody>
</table>