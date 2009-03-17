gclms.ForumTopicController = {
	selectThread: function() {
		
	}
}

gclms.Triggers.update({
	'#gclms-thread-listing ul ul li': gclms.ForumTopicController.selectThread
});