<div class="gclms-assignment-association gclms-page-object" gclms:assignment-association-id="<?= $id ?>">
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
				<th>
					<? __('Page title') ?>
				</th>
				<td>
					<input type="hidden" name="data[Assignment][AssociatedObject][<?= $id ?>][model]" value="Page" />
					<input type="hidden" name="data[Assignment][AssociatedObject][<?= $id ?>][foreign_key]" value="<?= @$foreign_key ?>" />
					<input type="text" disabled="disabled" value="<?= @$title ?>" class="gclms-associated-object-title" />
				</td>
			</tr>
			<tr class="gclms-figure-results-into-grade">
				<th width="1">
					<label for="results-figured-into-grade-<?= $id ?>]"><? __('Figure results into grade?') ?></label>
				</th>
				<td width="*">
					<input 
						type="checkbox" 
						name="data[Assignment][AssociatedObject][<?= $id ?>][results_figured_into_grade]" 
						value="1" 
						class="gclms-figured-into-grade"
						<? if(!empty($percentage_of_grade)): ?>checked="checked"<? endif; ?>
						id="results-figured-into-grade-<?= $id ?>]" />
				</td>
			</tr>
			<tr class="gclms-percentage-of-grade <?= empty($percentage_of_grade) ? 'gclms-hidden' : '' ?>">
				<th>
					<label for="percentage-of-total-grade-<?= $id ?>]"><? __('Percentage of grade') ?></label>
				</th>
				<td>
					<select name="data[Assignment][AssociatedObject][<?= $id ?>][percentage_of_grade]" id="percentage-of-total-grade-<?= $id ?>">
						<? foreach(range(100,0) as $percentage): ?>
							<option value="<?= $percentage ?>" <? if((int) $percentage_of_grade == (int) $percentage): ?>selected="selected"<? endif; ?>>
								<?= $percentage ?>%
							</option>
						<? endforeach; ?>
					</select>
				</td>
			</tr>
		</tbody>
	</table>
</div>