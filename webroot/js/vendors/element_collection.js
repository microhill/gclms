// Adds jQuery-style element collection methods to the return value of $$.
// Freely distributable under the same terms as Prototype's license:
// http://dev.rubyonrails.org/browser/spinoffs/prototype/trunk/LICENSE

/*

Object.blend = function(destination, source) {
  for (var key in source)
    if (Object.isUndefined(destination[key]))
      destination[key] = source[key];
  return destination;
};

Element.Collection = function(collection) {
  return Object.blend(collection.toArray(), Element.Collection.Methods);
};

Element.addMethods = Element.addMethods.wrap(function(a) {
  (a = $A(arguments)).shift().apply(this, a);
  
  Element.Collection.Methods = Object.keys(Element.Methods).inject({ }, function(methods, key) {
    var value = Element.Methods[key];
    if (Object.isFunction(value)) {
      methods[key] = value.wrap(function(proceed, args) {
        (args = $A(arguments)).shift();
        return this.map(function(element) { 
          return proceed.apply(element, [element].concat(args));
        });
      });
    }
    
    return methods;
  });
});

Function.prototype.collectionize = function(constructor) {
  return this.wrap(function(proceed, a, collection) {
    if (Object.isArray(collection = (a = $A(arguments)).shift().apply(this, a)))
      return new constructor(collection);
    return collection;
  });
};

Element.addMethods();
$$ = $$.collectionize(Element.Collection);

*/