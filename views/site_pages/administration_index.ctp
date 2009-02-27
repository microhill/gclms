<?
//$html->css('site_pages', null, null, false);

$javascript->link(array(
	'vendors/prototype1.6.0.3',
	'vendors/prototype_extensions1.0',
	'gclms',
	//'site_pages'
), false);

echo $this->element('left_column'); ?>
	
<div class="gclms-center-column">
	<div class="gclms-content articles">	
		<?= $this->element('notifications'); ?>
		<h1><? __('Site Pages') ?></h1>
		<table class="gclms-buttons">
			<tr>
				<td><button href="/administration/site_pages/add"><? __('Add') ?></button></td>
			</tr>
		</table>
		<? if(!empty($this->data)): ?>
			
			<table class="gclms-tabular gclms-hover-rows" cellspacing="0" id="gclms-site-pages">
				<tbody>
					<tr>
						<th>
							<? __('Title') ?>
						</th>
					</tr>
					<? foreach($this->data as $site_page): ?>
						<tr>
							<td>
								<a href="/administration/site_pages/edit/<?= $site_page['SitePage']['id'] ?>"><?= $site_page['SitePage']['title'] ?></a>
							</td>
						</tr>
					<? endforeach; ?>
				</tbody>
			</table>
		<? endif; ?>
	</div>
</div>

<?= $this->element('right_column'); ?>