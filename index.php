<?php
class eventHandler {
	var $events = array();
	
	function event($event, $func=false) {
		if(!$func) $this->triggerEvent($event);
		else $this->addEvent($event, $func);
	}
	
	function addEvent($event, $func) {
		$this->events[$event][] = $func;
	}
	
	function triggerEvent($event) {
		if(is_string($event) && is_array($this->events[$event])) {
			foreach($this->events[$event] as $function) {
				$function();
			}
		}
	}
	
	function __call($a, $b) {
		if(empty($b)) $this->triggerEvent($a);
		else { foreach($b as $func) { $this->events[$a][] = $func; } }
	}
	
}
?>