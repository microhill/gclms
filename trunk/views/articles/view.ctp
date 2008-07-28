<?
$html->css('/' . $group['web_path'] . '/files/css', null, null, false);

$javascript->link(array(
	'vendors/prototype',
	'prototype_extensions',
	'gclms',
	'articles'
), false);

echo $this->element('left_column'); ?>
<div class="gclms-center-column">
    <div class="gclms-content gclms-article">
        <div class="gclms-option-buttons">
            <a class="gclms-edit" href="<?= $groupAndCoursePath ?>/articles/edit/<?= $this->data['Article']['id'] ?>" target="_top"><? __('Edit') ?></a>
			<? if(!$framed): ?>
	            <a class="gclms-view-with-frames" href="<?= $groupAndCoursePath ?>/classroom/article/<?= $this->data['Article']['id'] ?>"><? __('View with frames') ?></a>
			<? endif; ?>
        </div>
        <div class="gclms-step-back">
            <a href="../../articles">
                <? __('All Articles') ?>
            </a>
        </div>
        <h1>
            <?= $this->data['Article']['title'] ?>
        </h1>
        <?= $this->data['Article']['content'] ?>
    </div>
</div>