<div class="gclms-assignment-association gclms-forum-object" gclms:assignment-association-id="<?= $id ?>">
	<table class="gclms-tabular-form" cellspacing="0">
		<tbody>
			<tr>
				<th colspan="2">
		            <div class="gclms-left">
		                <img src="/img/icons/oxygen/16x16/actions/edit-delete.png" class="gclms-delete-associated-object gclms-delete" />
		            </div>
				</th>
			</tr>
			<tr>
				<th width="1">
					<? __('Forum title') ?>
				</th>
				<td width="*">
					<input type="hidden" name="data[Assignment][AssignmentAssociation][<?= $id ?>][model]" value="Forum" />
					<input type="hidden" name="data[Assignment][AssignmentAssociation][<?= $id ?>][foreign_key]" value="<?= @$foreign_key ?>" />
					<input type="text" disabled="disabled" value="<?= @$title ?>" class="gclms-associated-object-title" />
				</td>
			</tr>
		</tbody>
	</table>
</div>