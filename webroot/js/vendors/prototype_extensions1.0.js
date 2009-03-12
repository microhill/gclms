/*global $, $A, $H, Ajax, Element, Client */

Element.addMethods({
    findParent: function(element, tagName){
        while (element.parentNode && element.tagName) {
            element = element.parentNode;
            var targetTagName = tagName.toUpperCase();
            var elementTagname = element.tagName;
            elementTagname = elementTagname.toUpperCase();
            if (targetTagName == elementTagname) {
                return element;
            }
        }
        
        return element;
    },
    
    // Behold, the magic method
    observeRules: function(element, rules){
        rules = $H(rules);
        
        rules.each(function(rule){
            if (Object.isFunction(rule.value)) {
                var selectors = $A(rule.key.split(','));
                selectors.each(function(selector){
                    var pair = selector.split(':');
                    if (pair.length > 2) {
                        pair = [pair.slice(0, pair.length - 1).join(':'), pair[pair.length - 1]];
                    }
                    else 
                        if (pair.length == 2 && (pair[1].indexOf('(') != -1 ||['empty','enabled','disabled','checked'] .in_array(pair[1]))) {
                            pair = [pair.slice(0, 2).join(':'), ''];
                        }
                    
                    if (pair[0] && pair[1] && pair[1] != 'loaded') {
                        $(element).select(pair[0]).each(function(element){
                            element.observe(pair[1], rule.value);
                        });
                    }
                    else 
                        if (pair[1] && pair[1] == 'loaded') {
                            rule.value.bind(element)();
                        }
                        else 
                            if (pair[1]) {
                                element.observe(pair[1], rule.value);
                            }
                            else 
                                if (pair[0]) {
                                    $(element).select(pair[0]).each(function(element){
                                        rule.value.bind(element)();
                                    });
                                }
                });
            }
            else {
                //Change this
				try {
					$(element).select(rule.key).each(function(element){
	                    element.observeRules(rule.value);
	                });					
				} catch(e) {
					alert(rule.key)
				}

            }
        });
        
        return element;
    },
    
    toggleDisplayBlock: function(element){
        $(element).style.display = $(element).style.display == 'none' ? 'block' : 'none';
        return element;
    },

    displayAsBlock: function(element){
        $(element).style.display = 'block';
        return element;
    },
	    
    displayAsInline: function(element){
        $(element).style.display = 'inline';
        return element;
    },
    
    displayAsTableRow: function(element){
         $(element).style.display = 'table-row'; //use block for IE < 8
        
        return element;
    },
    
    displayAsTableCell: function(element){
        $(element).setStyle({
            display: 'table-cell'
        });
        return element;
    },
    
    display: function(element){
        /*
         switch ($(element).nodeName) {
         case 'table':
         displayType = 'table';
         break;
         }
         */
        $(element).style.display = 'table-cell';
    },
    
    disable: function(element){
        $(element).setAttribute('disabled', 'disabled');
    },
    
    enable: function(element){
        $(element).removeAttribute('disabled');
    }
});

Array.prototype.in_array = function(obj){
    var length = this.length;
    for (var x = 0; x <= this.length; x++) {
        if (this[x] == obj) {
            return true;
        }
    }
    return false;
};

Array.prototype.walk = function(f){
    var a = [], i = this.length;
    while (i--) {
        a.push(f(this[i]));
    }
    return a.reverse();
};

Ajax.Responders.register({
    onCreate: function(){
        if ($('gclms-spinner')) {
            $('gclms-spinner').style.display = 'block';
        }
    },
    onComplete: function(){
        if ($('gclms-spinner')) {
            $('gclms-spinner').style.display = 'none';
        }
    }
});