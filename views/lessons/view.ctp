<?
$javascript->link(array(
	'vendors/prototype',
	'prototype_extensions',
	'gclms',
	'vendors/uuid',
	'vendors/scriptaculous1.8.1/scriptaculous',
	'vendors/scriptaculous1.8.1/dragdrop',
	'edit_lesson'
), false);

echo $this->renderElement('left_column');
?>
		
<div class="gclms-center-column">
	<div class="gclms-content" id="lesson" lesson:id="<?= $lesson['id'] ?>">
		<div id="gclms-spinner"><img src="/img/permanent/spinner2007-09-14.gif" alt="Spinner" /></div>
		<div class="gclms-step-back gclms-forceload"><a href="/<?= $group['web_path'] ?>/<?= $course['web_path'] ?>/lessons"><? __('Back to Units and Lessons') ?></a></div>
		<h1>
			<span class="title"><?= implode(order(array(__('Lesson: ',true),$lesson['title'])))?></span>
		</h1>
		<p class="buttons">
			<button class="add" id="addTopic" gclms:prompt-text="<? __('Enter the title of the topic:') ?>">Add Topic</button>
			<button class="add" id="addPage" gclms:prompt-text="<? __('Enter the title of the page:') ?>">Add Page</button>
			<button class="rename" id="renamePage" gclms:prompt-text="<? __('Enter the new title of the page:') ?>">Rename</button>
			<button class="rename" id="renameTopic" gclms:prompt-text="<? __('Enter the new title of the topic:') ?>">Rename</button>
			<button class="delete" id="deleteTopic" notempty:message="<? __('This topic is not empty.') ?>" gclms:confirm-text="<? __('Are you sure you want to delete this topic?') ?>">Delete</button>
			<button class="delete" id="deletePage" gclms:confirm-text="<? __('Are you sure you want to delete this page?') ?>">Delete</button>
			<button class="edit" id="editTopic">Edit</button>
			<button class="edit" id="editPage">Edit</button>
		</p>
		<div id="topics">
		<?			
		$topics = array();
		$categorizedPages = array();
		$uncategorizedPages = array();

		foreach($pages as $page) {
			if(!empty($page['Page']['topic_head'])) {
				$topics[$page['Page']['order']] = $page['Page'];
				continue;
			}
			if(empty($page['Page']['topic_id'])) {
				$uncategorizedPages[$page['Page']['order']] = $page['Page'];
				continue;
			}
			$topic_id = $page['Page']['topic_id'];
			if(empty($categorizedPages[$topic_id]))
				$categorizedPages[$topic_id] = array();
			$categorizedPages[$topic_id][$page['Page']['order']] = $page['Page'];
		}
		foreach($topics as $topic): ?>
			<div id="<?= 'topic_' . $topic['id'] ?>" page:id="<?= $topic['id'] ?>" class="topic">
				<h2 class="topicHandle" id="topicHandle_<?= $topic['id'] ?>">
					<a href="#"><?= $topic['title'] ?></a>
				</h2>
				<ul id="topicPages<?= 'topic_' . $topic['id'] ?>" class="topicPages">
				<? 
				if(@$categorizedPages[$topic['id']]) {
					foreach($categorizedPages[$topic['id']] as $page)
						echo '<li id="page_' . $page['id'] . '" page:id="' . $page['id'] . '"><a href="#">' . $page['title'] . '</a></li>';
				}
					?>
				</ul>
			</div>
		<?
		endforeach;
		
		echo '</div>';
		
		echo '<div id="uncategorizedPagesContainer" page:id="0" class="topic">';
		echo '<h2 id="uncategorizedPagesHeader" class="' . (empty($topics) ? 'hidden' : '') . '"><a href="#">' . __('Uncategorized Lesson Items',true) . '</a></h2>';
		echo '<ul id="uncategorizedPagesList" class="topicPages">';
		foreach($uncategorizedPages as $page) {
			echo '<li id="page_' . $page['id'] . '" page:id="' . $page['id'] . '"><a href="#">' . $page['title'] . '</a></li>';
		}
		echo '</ul>';
		echo '</div>';
		?>
	</div>
</div>

<?= $this->renderElement('right_column'); ?>