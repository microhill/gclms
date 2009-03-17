gclms.ForumTopicController = {
	selectThread: function(event) {
		event.stop();
		var threadId = this.getAttribute('gclms-thread-id');
		
		$$('#gclms-threads .gclms-thread:not(.gclms-hidden)').each(function(post) {
			post.addClassName('gclms-hidden');
		});

		$('gclms-thread-' + threadId).removeClassName('gclms-hidden')
		$('ReplyParentPostId').value = threadId;
		
		$$('#gclms-thread-listing a.gclms-selected').each(function(post) {
			post.removeClassName('gclms-selected');
		});
		
		this.addClassName('gclms-selected');
	}
}

gclms.Triggers.update({
	'#gclms-thread-listing a:click': gclms.ForumTopicController.selectThread
});