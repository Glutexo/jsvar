# json_encode replacement that allows raw JS values #

Ever wanted to compose a JavaScript object using PHP, but _json_encode_ wasn’t enough because it support only scalar values? This class allows you to put any arbitraty code in the object, e.g. function calls, expressions, variables etc.

The value of JsVar and JsRawVar object can be accessed and modified by its _value_ attribute.

JsVar and JsRawVar objects can be used as strings.

## Usage ##

Here is an example of a jQuery AJAX call options object composed in PHP. The
success callback is put there as raw JavaScript. Because the $prefix is not a
simple string, but a JsVar instance, it can be used directly in the string
without calling _json_encode_ and it still gets encoded.

```php
$prefix = new JsVar("Response is: ");

$obj = new JsVar(array(
	'url' => 'my_awesome_script.php',
	'method' => 'POST',
	'success' => new JsRawVar("function(data) { alert($prefix + data); }")
));

print $obj;
```