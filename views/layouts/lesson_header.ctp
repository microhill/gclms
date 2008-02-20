<?=$html->docType('xhtml-strict'); ?>
<html xmlns="http://www.w3.org/1999/xhtml" lang="<?= $language ?>" dir="<? __('TEXT DIRECTION'); ?>">

<? include 'views/layouts/head.ctp'; ?>

<body>
	<?php echo $content_for_layout ?>
</body>
</html>