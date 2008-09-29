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
	
	function triggerEvent($event, $data) {
		$eventClass = new event;
		$eventClass->data = $data;
		if(is_string($event) && is_array($this->events[$event])) {
			foreach($this->events[$event] as $function) {
				$function($eventClass);
			}
		}
	}
	
	function __call($a, $b) {
		$allClosures = true;
		foreach($b as $option) {
			if(!$option instanceof Closure) {
				$allClosures = false;
			}
		}
		if(empty($b) || !$allClosures) $this->triggerEvent($a, $b);
		else { foreach($b as $func) { $this->events[$a][] = $func; } }
	}
	
}
class event {
	
}
?>