<!--div class="gclms-menubar">
	<? foreach($buttons as $button): ?>
		<button id="<?= $button['id'] ?>" class="<?= $button['class'] ?>"
		<?
		
		if(!empty($button['accesskey'])) {
			echo 'accesskey="' . $button['accesskey'] . '"';
		}
		
		if(!empty($button['strings'])) {
			foreach($button['strings'] as $name => $value) {
				echo $name . '="' . __($value,true) . '" ';
			}
		}
		?>
		>
			<? __($button['label']) ?>
		</button>
	<? endforeach; ?>
</div--> 

<table class="gclms-menubar">
	<tr>
	<? foreach($buttons as $button): ?>
		<td>
			<button id="<?= $button['id'] ?>" class="<?= $button['class'] ?>"
			<?
			
			if(!empty($button['disabled'])) {
				echo 'disabled="' . $button['disabled'] . '" ';
			}
			
			if(!empty($button['accesskey'])) {
				echo 'accesskey="' . $button['accesskey'] . '" ';
			}
			
			if(!empty($button['strings'])) {
				foreach($button['strings'] as $name => $value) {
					echo $name . '="' . __($value,true) . '" ';
				}
			}
			?>
			>
				<? __($button['label']) ?>
			</button>
		</td>
	<? endforeach; ?>
	</tr>
</table> 