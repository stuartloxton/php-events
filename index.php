<?php
class EventHandler {
	var $events = array();
	
	function event($event, $func=false) {
		if(!$func) $this->triggerEvent($event);
		else $this->addEvent($event, $func);
	}
	
	function addEvent($event, $func) {
		$this->events[$event][] = $func;
	}
	
	function triggerEvent($event, $data) {
		$eventClass = new Event;
		$eventClass->data = $data;
		$eventClass->this = $this;
		if(is_string($event) && is_array($this->events[$event])) {
			$i = 0;
			while($i < count($this->events[$event])) {
				$return = $this->events[$event][$i]();
				if(!$return) { $i = count($this->events[$event]); }
				$i++;
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
class Event {
	
	static function stop() {
		return false;
	}
	
}
?>