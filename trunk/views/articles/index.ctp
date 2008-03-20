<?
$html->css('articles', null, null, false);

$javascript->link(array(
	'vendors/prototype',
	'prototype_extensions',
	'gclms',
	'articles'
), false);

echo $this->renderElement('left_column'); ?>
	
<div class="gclms-center-column">
	<div class="gclms-content articles">	
		<?= $this->renderElement('notifications'); ?>
		<h1><? __('Articles') ?></h1>
		<div id="gclms-menubars">
			<? echo $this->renderElement('menubar',array('buttons' => array(
				array(
					'id' => 'addArticle',
					'class' => 'gclms-add',
					'label' => '<u>A</u>dd Article',
					'accesskey' => 'a'
				)
			)));
			?>
		</div>		
		<ul class="articles">
			<? foreach($this->data as $article): ?>
				<li>
					<a href="/<?= $group['web_path'] ?>/<?= $course['web_path'] ?>/articles/view/<?= $article['Article']['id'] ?>"><?= $article['Article']['title'] ?></a>
				</li>
			<? endforeach; ?>
		</ul>
	</div>
</div>

<?= $this->renderElement('right_column'); ?>