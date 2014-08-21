<?php
// No bootstrap -- not needed for just one test file.
require_once('src/JsRawVar.php');
require_once('src/JsVar.php');
class JsVarTest extends PHPUnit_Framework_TestCase {
	public function testEmptyObjectRenders() {
		$obj = new JsVar(new stdClass);
		$this->assertEquals(json_encode(new stdClass),$obj);
	}

	public function testObjectWithSimpleValueRenders() {
		$items = array("jablko" => "hruška");
		$obj = new JsVar($items);
		$this->assertEquals(json_encode($obj->value),$obj);
	}

	public function testObjectWithMoreSimpleValuesRenders() {
		$items = array("ovoce" => "jablko","zelenina" => "mrkev");
		$obj = new JsVar($items);
		$this->assertEquals(json_encode($obj->value),$obj);
	}

	public function testObjectWithNumericKeysRenders() {
		$items = array(0 => "jablko",1 => "mrkev","jiný" => "ořech");
		$obj = new JsVar($items);
		$this->assertEquals(json_encode($obj->value),$obj);
	}

	public function testObjectWithSimpleValuesComparesToManuallyWrittenString() {
		$items = array("ovoce" => "jablko","zelenina" => "mrkev");
		$obj = new JsVar($items);
		$this->assertEquals("{\"ovoce\":\"jablko\",\"zelenina\":\"mrkev\"}",$obj);
	}

	public function testObjectWithRawValueRenders() {
		$value = "function() { }";
		$obj = new JsVar(array("callback" => new JsRawVar($value)));
		$this->assertEquals("{\"callback\":$value}",$obj);
	}

	public function testObjectWithNestedObjectRenders() {
		$raw = json_encode(array('jídlo' => array('ovoce' => 'jablko')));
		$obj = new JsVar(array('jídlo' => new JsVar(array('ovoce' => 'jablko'))));
		$this->assertEquals($raw,$obj);
	}
	
	public function testNonArrayValueRenders() {
		$value = "jablko";
		$obj = new JsVar($value);
		$this->assertEquals(json_encode($value),$obj);
	}

	public function testEmptyArrayRenders() {
		$value = array();
		$obj = new JsVar($value);
		$this->assertEquals(json_encode($value),$obj);
	}

	public function testSequestialArrayRenders() {
		$value = array("jablko","hruška");
		$obj = new JsVar($value);
		$this->assertEquals(json_encode($value),$obj);
	}

	public function testDeeplyNestedRawVarRenders() {
		$value = array("jídlo" => array("ovoce" => new JsRawVar("'hruška'")));
		$obj = new JsVar($value);
		
		$expected = "{";
		$expected .= json_encode("jídlo");
		$expected .= ":{";
		$expected .= json_encode("ovoce");
		$expected .= ":'hruška'}}";
		
		$this->assertEquals($expected,$obj);
	}
}
?>
