<table class="gclms-menubar"<?
	if(!empty($id)) {
		echo 'id="' . $id . '" ';
	}
?>>
	<tr>
	<? foreach($buttons as $button): ?>
		<td id="<?= $button['id'] ?>">
			<button class="<?= $button['class'] ?>"
			<?
			
			if(!empty($button['disabled'])) {
				echo 'disabled="' . $button['disabled'] . '" ';
			}
			
			if(!empty($button['accesskey'])) {
				echo 'accesskey="' . $button['accesskey'] . '" ';
			}
			
			if(!empty($button['strings'])) {
				foreach($button['strings'] as $name => $value) {
					echo $name . '="' . $value . '" ';
				}
			}
			?>
			>
				<?= $button['label'] ?>
			</button>
		</td>
	<? endforeach; ?>
	</tr>
</table> 