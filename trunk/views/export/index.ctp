<?
$html->css('export', null, null, false);

echo $this->renderElement('left_column'); ?>
<div class="gclms-center-column">
    <div class="gclms-content">
        <h1>
            <? __('Choose an Export Format') ?>
        </h1>
        <ul class="gclms-export-menu">
            <li class="gclms-odt">
                <div class="gclms-export-title"><? __('OpenDocument Text (.odt)') ?></div>
                <div>This can be opened using the free <a href="http://www.openoffice.org/" />OpenOffice.org</a> office suite.</div>
				<div>
					<?
					$odt_file = TMP . 'export' . DS . $course['id'] . '.odt';
					
					if(file_exists($odt_file)): ?>
						<a href="<?= $groupAndCoursePath ?>/export/odt" class="gclms-download">
							Download
							(updated <?= date('F j, Y', filemtime($odt_file)) ?>)</a>
					<? endif; ?>
					<a href="<?= $groupAndCoursePath ?>/export/generate_odt" class="gclms-generate">Generate</a>
				</div>
            </li>
            <li class="gclms-archive">
                <div class="gclms-export-title"><? __('Archive (.zip)') ?></div>
                <div>Useful for backup or for distributing the course on a CD or flash drive.</div>
				<div>
					<?
					$archive_file = TMP . 'export' . DS . $course['id'] . '.zip';
					
					if(file_exists($archive_file)): ?>
						<a href="<?= $groupAndCoursePath ?>/export/archive" class="gclms-download">
							Download
							(updated <?= date('F j, Y', filemtime($archive_file)) ?>)</a>
					<? endif; ?>
					<a href="<?= $groupAndCoursePath ?>/export/generate_archive" class="gclms-generate">Generate</a>
				</div>
            </li>
            <!-- li class="gclms-pdf">
                <a href="<?= $groupAndCoursePath ?>/export/odt">
                    <? __('Portable Document Format (.pdf)') ?>
                </a>
				<br/>
                <span></span>
            </li -->
        </ul>
    </div>
</div>
<?= $this->renderElement('right_column'); ?>
