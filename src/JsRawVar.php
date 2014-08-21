<?php
class JsRawVar {
	public $value = "";
	
	function __construct($value) {
		$this->value = $value;
	}

	public function __toString() {
		return (string) $this->value;
	}
}
?>
