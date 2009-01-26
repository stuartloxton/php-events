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
		$eventClass->parent = $this;
		if(is_string($event) && is_array($this->events[$event])) {
			$i = 0;
			while($i < count($this->events[$event])) {
				$code = $this->events[$event][$i]($eventClass);
				if($code === false) { $i = count($this->events[$event]); }
				elseif($code === 0 ) { unset($this->events[$event][$i]); }
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
	
	const UNBIND = 0;
	const STOP = false;
	
}
?>