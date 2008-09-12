<?
if(empty($delete_url)) {
	$delete_url = '';
	if(!empty($this->params['administration']))
		$delete_url .= '/' . $this->params['administration'];
	if(!empty($groupAndCoursePath))
		$delete_url .= $groupAndCoursePath . '/';
	else
		$delete_url .= '/';
	if(!empty($this->params['controller']))
		$delete_url .= $this->params['controller'] . '/';
	$delete_url .= 'delete/' . $this->data[$this->params['models'][0]]['id'];

}
?>

<table class="gclms-buttons">
	<tr>
		<td>
			<?= $form->submit('Save',array('div' => false)) ?>
		</td>
		<td>
			<button class="gclms-delete" href="<?= $delete_url ?>" gclms:confirm-text="<?= $confirm_delete_text ?>">Delete</button>
		</td>
	</tr>
</table>