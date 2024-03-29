<?
$html->css('articles', null, null, false);

$javascript->link(array(
	'vendors/prototype1.6.0.3',
	'vendors/prototype_extensions1.0',
	'gclms',
	'articles'
), false);

echo $this->element('left_column'); ?>
	
<div class="gclms-center-column">
	<div class="gclms-content articles">	
		<?= $this->element('notifications'); ?>
		<? if(!$framed): ?>
			<h1><? __('Articles') ?></h1>
			<? if(Permission::check('Content')): ?>
				<button href="articles/add"><? __('Add') ?></button>
			<? endif; ?>
		<? endif; ?>
		<ul class="articles">
			<? foreach($this->data as $article): ?>
				<li>
					<a href="/<?= Group::get('web_path') ?>/<?= $course['web_path'] ?>/articles/view/<?= $article['Article']['id'] ?>"><?= $article['Article']['title'] ?></a>
				</li>
			<? endforeach; ?>
		</ul>
	</div>
</div>

<?= $this->element('right_column'); ?>