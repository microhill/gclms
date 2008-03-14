<? echo $this->renderElement('left_column'); ?>
<div class="gclms-center-column">
    <div class="gclms-content article">
        <div class="gclms-option-buttons">
            <a class="gclms-edit-article" href="<?= $groupAndCoursePath ?>/articles/edit/<?= $this->data['Article']['id'] ?>">Edit</a>
            <a class="gclms-view-with-frames" href="<?= $groupAndCoursePath ?>/classroom/article/<?= $this->data['Article']['id'] ?>">View with frames</a>
        </div>
        <div class="gclms-step-back">
            <a href="/<?= $group['web_path'] ?>/<?= $course['web_path'] ?>/articles">
                <? __('All Articles') ?>
            </a>
        </div>
        <h1>
            <?= $this->data['Article']['title'] ?>
        </h1>
        <?= $this->data['Article']['content'] ?>
    </div>
</div>