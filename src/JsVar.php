<?php
/**
* Allows creating JS object with not only scalar values, but with expressions,
* functions etc. When used as a string, it converts in a similar fashion as
* PHP’s json_encode function with one difference: When a JsRawVar is encoun-
* tered, it’s put into the object diretly without any escaping/encoding.
*/
class JsVar extends JsRawVar {
	public $value = array();
	
	public function __toString() {
		if(is_array($this->value)) {
			if($this->value === array_values($this->value)) {
				// Ordered list. Keys are number from 0 without holes.
				$out = "[";
				$items = array_map(array($this,'Render'),$this->value);
				$out .= implode(",",$items);
				$out .= "]";
				return $out; 
			} else {
				// Hash/dictionary - array with named keys. Or numbered keys,
				// but with holes or not from 0. Mimics json_encode.
				$out = "{";
				$items = array();
				foreach($this->value as $k => $v) {
					$item = "";
					$item .= json_encode((string) $k);
					$item .= ":";
					$item .= $this->Render($v);
					$items[] = $item;
				}
				$out .= implode(",",$items);
				$out .= "}";
			}
			return $out;
		} else {
			return $this->Render($this->value);
		}
	}
	
	private function Render($v) {
		if($v instanceof JsRawVar || $v instanceof JsVar) {
			// This is the main point: JsRawVarClass instances are not encoded.
			return $v;
		} elseif(is_array($v)) {
			// More values - parse them by this class as well. This allows to
			// instantiate JsVar manually only once for the root element.
			return new JsVar($v);
		} else {
			return json_encode($v);
		}
	}
}
?>
