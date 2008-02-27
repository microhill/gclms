Element.addMethods({
	findParent: function(element, tagName) {
		while(element.parentNode && element.tagName) {
			element = element.parentNode;
			targetTagName = tagName.toUpperCase();
			elementTagname = element.tagName;
			elementTagname = elementTagname.toUpperCase();
			if(targetTagName == elementTagname) {
				return element;
			}
		}

		return element;
	},

	observeRules: function(element, rules) {
		rules = $H(rules);

		rules.each(function(rule){
			if(Object.isFunction(rule.value)) {
				var selectors = $A(rule.key.split(','));
				selectors.each(function(selector) {
					var pair = selector.split(':');
					if(pair[0] && pair[1] && pair[1] != 'loaded') {
						$(element).select(pair[0]).each(function(element) {
							element.observe(pair[1], rule.value);
						});
					} else if(pair[1] && pair[1] == 'loaded'){
						rule.value.bind(element)();
					} else if(pair[1]){
						element.observe(pair[1], rule.value);
					} else if(pair[0]) {
						$(element).select(pair[0]).each(function(element) {
							rule.value.bind(element)();
						});
					}
				});
			} else {
				$(element).select(rule.key).each(function(element) {
					element.observeRules(rule.value);
				});
			}
		});

		return element;
	},

	toggleDisplayBlock: function(element) {
	    $(element).style.display = $(element).style.display == 'none' ? 'block' : 'none';
	    return element;
	},

	displayAsBlock: function(element) {
	    $(element).style.display = 'block';
	    return element;
	},

	displayAsInline: function(element) {
	    $(element).style.display = 'inline';
	    return element;
	},

	showAsTableRow: function(element) {
	    $(element).style.display = 'table-row';
	    return element;
	}
});

String.prototype.trim = function() {
    return this.replace(/^\s*/, "").replace(/\s*$/, "");
};

String.prototype.interpolate = function(hash) {
    template = new Template(this);
    return template.evaluate(hash);
};

Ajax.Responders.register({
	onCreate: function() {
		if ($('gclms-spinner')) {
			$('gclms-spinner').style.display = 'block';
		}
	},
	onComplete: function() {
		if($('gclms-spinner')) {
			$('gclms-spinner').style.display = 'none';
		}
	}
});