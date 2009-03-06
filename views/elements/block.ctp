<? if(!empty($content)): ?>
	<div class="gclms-panel">
		<div class="gclms-top">
			<div class="gclms-top-left">
				<div class="gclms-top-right">
					<div class="gclms-button gclms-up"></div>
					<h2><?= __($title,true) ?></h2>
				</div>
			</div>
		</div>
		<div class="gclms-panel-content">
			<?= $content ?>
		</div>
	</div>
<? endif; ?>