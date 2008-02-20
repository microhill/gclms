<?= implode(order(array(
	$this->renderElement('user_bar'),
	$this->renderElement('breadcrumbs')
))); ?>