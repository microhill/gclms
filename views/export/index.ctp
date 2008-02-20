<?= $this->renderElement('left_column'); ?>
<div class="gclms-center-column">
    <div class="gclms-content">
        <h1>
            <? __('Choose an Export Format') ?>
        </h1>
        <ul class="gclms-export-menu">
            <li class="gclms-odt">
                <a href="<?= $groupAndCoursePath ?>/export/odt">
                    <? __('OpenDocument Text (.odt)') ?>
                </a>
                <br/>
                <span>This can be opened using the free <a href="http://www.openoffice.org/" />OpenOffice.org</a> office suite or a free <a href="http://downloads.sourceforge.net/odf-converter/OdfAddInForWordSetup-en-1.1.exe?modtime=1196683557&big_mirror=0">plugin</a> for Microsoft Office.</span>
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
