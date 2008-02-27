$$('.gclms-bible a.expandableBibleBook:click').each(function(a){
	a.observe('click',function(event){
		event.stop();
		span = this.next('span');
		span.displayAsInline();
		this.replace(this.innerHTML);
	});
});