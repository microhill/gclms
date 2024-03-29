<?
$textarea_id = empty($textarea_id) ? String::uuid() : $textarea_id;
if(empty($textarea_id) && !empty($textarea['id']))
	$textarea_id = $textarea['id'];
?>
<div class="gclms-page-item gclms-textarea" textarea:id="<?= $textarea_id ?>">
    <?
	echo $form->hidden('Textarea][' . $textarea_id . '.id',array(
		'value' => @$textarea['id']
	));
	?>
    <table class="gclms-tabular-form" cellspacing="0">
        <tbody>
            <tr>
                <th>
                    <div class="gclms-left">
                        <img src="/img/icons/oxygen/16x16/actions/edit-delete.png" gclms:confirm-text="<? __('Are you sure you want to delete this content?') ?>" class="gclms-delete-textarea"/>
                    </div>
                    <div class="gclms-right">
                        <img src="/img/icons/oxygen_refit/16x16/actions/go-up-blue.png" class="gclms-move-up" alt="<? __('Move up') ?>" />
                        <img src="/img/icons/oxygen_refit/16x16/actions/go-down-blue.png" class="gclms-move-down" alt="<? __('Move down') ?>" />
                    </div>
                </th>
            </tr>
            <tr>
                <td>
                    <?
					echo $form->input('Textarea][' . $textarea_id . '.content',array(
						'label' =>  false,
						'between' => null,
						'rows' => 20,
						'cols' => 80,
						'value' => @$textarea['content'],
						'div' => false,
						'class' => 'gclms-tinymce-enabled'
					));
					?>
                </td>
            </tr>
        </tbody>
    </table>
    <p>
		<?= $this->element('buttons', array('buttons' => array(
			array(
				'text' => 'Insert Question',
				'class' => 'gclms-insert-question'
			),
			array(
				'text' => 'Insert Content',
				'class' => 'gclms-insert-textarea'
			)
		)));
		?>
    </p>
</div>