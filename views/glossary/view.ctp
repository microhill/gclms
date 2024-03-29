<?
$javascript->link(array(
	'vendors/prototype1.6.0.3',
	'vendors/prototype_extensions1.0',
	'gclms',
	'glossary'
), false);

echo $this->element('left_column'); ?>
<div class="gclms-center-column">
    <div class="gclms-content gclms-glossary-term">
        <div class="gclms-option-buttons">
            <a class="gclms-edit" href="<?= $groupAndCoursePath ?>/glossary/edit/<?= $this->data['GlossaryTerm']['id'] ?>" target="_top"><? __('Edit') ?></a>
			<? if(!$framed): ?>
	            <a class="gclms-view-with-frames" href="<?= $groupAndCoursePath ?>/classroom/glossary/<?= $this->data['GlossaryTerm']['id'] ?>"><? __('View with frames') ?></a>
			<? endif; ?>
        </div>
        <div class="gclms-step-back">
            <a href="../../glossary">
                <? __('All Glossary Terms') ?>
            </a>
        </div>
        <h1>
            <?= $this->data['GlossaryTerm']['term'] ?>
        </h1>
        <?= $this->data['GlossaryTerm']['description'] ?>
    </div>
</div>
<?= $this->element('right_column'); ?>