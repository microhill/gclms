<?
$textarea_id = empty($textarea_id) ? String::uuid() : $textarea_id;
if(empty($textarea_id) && !empty($textarea['id']))
	$textarea_id = $textarea['id'];
?>

<div class="gclms-page-item textarea" textarea:id="<?= $textarea_id ?>">
	<?
	echo $form->hidden('Textarea][' . $textarea_id . '.id',array(
		'value' => @$textarea['id']
	));
	?>
	<table class="gclms-tabular-form" cellspacing="0">
		<tbody>
			<tr>
				<th>
					<p class="left">
						<button class="deleteTextarea delete" confirm:text="<? __('Are you sure you want to delete this content?') ?>">
							<? __('Delete Content') ?>
						</button>
					</p>

					<p class="right">
						<button class="moveUp">
							<? __('Move up') ?>
						</button>

						<button class="moveDown">
							<? __('Move down') ?>
						</button>
					</p>
				</th>
			</tr>
			<tr>
				<td>
					<?
					echo $form->input('Textarea][' . $textarea_id . '.content',array(
						'label' =>  false,
						'between' => null,
						'rows' => 20,
						'cols' => 100,
						'value' => @$textarea['content'],
						'div' => false
					));
					?>
				</td>
			</tr>
		</tbody>
	</table>

	<p>
		<button class="insertQuestion add"><img src="/img/permanent/icons/2007-09-13/add-12.png" /> <? __('Insert Question') ?></button>
		<button class="insertTextarea add"><img src="/img/permanent/icons/2007-09-13/add-12.png" /> <? __('Insert Content') ?></button>
	</p>
</div>