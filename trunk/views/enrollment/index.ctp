<?
$html->css('enrollment', null, null, false);

$javascript->link(array(
	'vendors/prototype1.6.0.3',
	'vendors/prototype_extensions1.0',
	'gclms',
	'enrollment'
), false);

echo $this->element('left_column'); ?>
	
<div class="gclms-center-column">
	<div class="gclms-content articles">	
		<?= $this->element('notifications'); ?>
		<h1><?= sprintf(__('Enroll in %s (%s)?',true),VirtualClass::get('title'),Course::get('title')) ?></h1>
		<? if(VirtualClass::get('price')): ?>
			<p><?= sprintf(__('Price: $%s',true), VirtualClass::get('price')) ?></p>
		<? endif; ?>
		<form action="<?= $groupAndCoursePath ?>/enrollment/proceed" method="post">
			<table class="gclms-buttons">
				<tr>
					<td><button class="gclms-yes"><? __('Yes') ?></button></td>
					<td><button class="gclms-no" href="<?= $groupAndCoursePath ?>"><? __('No') ?></button></td>
				</tr>
			</table>
		</form>
	</div>
</div>

<?= $this->element('right_column'); ?>