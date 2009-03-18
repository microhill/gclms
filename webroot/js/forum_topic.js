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
	},
	
	editPost: function(event) {
		event.stop();
		
		$('ReplyContent').innerHTML = this.up('td').down('.gclms-forum-post-content').innerHTML.stripTags().strip();

		$('gclms-reply-header').removeClassName('gclms-hidden');
		$('gclms-edit-post-header').addClassName('gclms-hidden');
		
		$('gclms-save-button').removeClassName('gclms-hidden');
		$('gclms-reply-button').addClassName('gclms-hidden');
		
		$('ReplyId').value = this.up('tbody').getAttribute('gclms-post-id');
		
		$('ReplyContent').focus();
	}
}

gclms.Triggers.update({
	'#gclms-thread-listing a:click': gclms.ForumTopicController.selectThread,
	'button.gclms-edit-post:click': gclms.ForumTopicController.editPost
});