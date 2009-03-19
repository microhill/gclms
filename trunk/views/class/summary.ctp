<div class="gclms-content gclms-class-information">
	<div>
		<strong><? __('Title:') ?></strong> <?= VirtualClass::get('title') ?>
	</div>
	<div>
		<? if(VirtualClass::get('enrollment_deadline')): ?>
			<strong><? __('Enrollment deadline:') ?></strong> <?= VirtualClass::get('enrollment_deadline') ?>
		<? endif; ?>
	</div>
	<div>
		<? if(VirtualClass::get('start')): ?>
			<strong><? __('Starts:') ?></strong> <?= VirtualClass::get('start') ?>
		<? endif; ?>
	</div>
	<div>
		<? if(VirtualClass::get('end')): ?>
			<strong><? __('Ends:') ?></strong> <?= VirtualClass::get('end') ?>
		<? endif; ?>
	</div>
	<div>
		<? if(VirtualClass::get('capacity')): ?>
			<strong><? __('Capacity:') ?></strong> <?= VirtualClass::get('capacity') ?>
		<? endif; ?>
	</div>
	<div>
		<button href="<?= $groupAndCoursePath ?>/enrollment"><? __('Enroll') ?></button>
	</div>
</div>