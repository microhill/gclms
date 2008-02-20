$$('.gclms-bible a.expandableBibleBook:click').each(function(a){
	a.observe('click',function(event){
		event.stop();
		span = this.next('span');
		span.showAsInline();
		this.replace(this.innerHTML);
	});
});