<?
if(empty($page_section)) {
	$page_section_id = String::uuid();
} else {
	$page_section_id = $page_section['id'];
}
?>
<div class="section" page_section:id="<?= $page_section_id ?>">
	<?
	echo $form->input('Page.PageSection][' . $page_section_id . '][content',array(
		'label' =>  __('Content', true),
		'between' => '<br/>',
		'rows' => 20,
		'cols' => 100,
		'class' => 'wysiwyg',
		'value' => @$page_section['content']
	));
	?>

	<div class="questions">
		<?
		if(isset($this->data['Question'])) {
			foreach($this->data['Question'] as $question) {
				echo $this->renderElement('question',array(
					'question' => $question,
					'page_section_id' => $page_section_id
				));
			}
		}
		?>
	</div>
	<p>
		<button class="addQuestion"><img src="/img/permanent/icons/2007-09-13/add-12.png" /> <? __('Add Question') ?></button> <span class="loadingQuestionIndicator"><img src="/img/permanent/spinner2007-09-14.gif" /></span>
	</p>

	<p>
		<button class="insertSection"><img src="/img/permanent/icons/2007-09-13/add-12.png" /> <? __('Add Content') ?></button> <span class="loadingQuestionIndicator"><img src="/img/permanent/spinner2007-09-14.gif" /></span>
	</p>
</div>