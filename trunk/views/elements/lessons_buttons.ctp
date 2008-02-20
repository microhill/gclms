<?
$reorderLessonsURL = $groupAndCoursePath . '/lessons/reorder';

if(count($lessons) > 1): 
?>
<button class="Reorder" link:href="<?= $reorderLessonsURL ?>">
	<img src="/img/permanent/icons/2007-09-13/reorder-12.png"/>
	<? __('Re-order') ?>
</button>
<? endif; ?>