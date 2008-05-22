<?=$html->docType('xhtml-strict'); ?>
<html xmlns="http://www.w3.org/1999/xhtml" lang="<?= $language ?>" dir="<? echo $text_direction; ?>">

<? include 'views/layouts/head.ctp'; ?>

<body>
	<?php echo $content_for_layout ?>
</body>
</html>