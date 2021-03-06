<?php
	include('php-events.php');

	class database extends EventHandler {
		
		function connect() { // Connection code would go here
			$this->connected();
		}
		
		function query($query) { // Query code would go in here
			$results = array(rand(), rand(), rand());
			$success = (rand() % 2) ? true : false;
			if($success) {
				$this->querySuccess($results, $query);
			} else {
				$this->queryError('Example Error', $query);
			}
		}
		
	}
	
	$db = new database;
	
	$db->connected(function($e=false) {
		define('DB_CONNECTED', 'true');
		echo '<h1>Connected</h1>';
		return Event::UNBIND;
	});
	$db->querySuccess(function($e=false) {
		echo '<h1>Query - '.$e->data[1].'</h1>';
		print_r($e->data[0]);
		return Event::STOP;
	});
	$db->queryError(function($e=false) {
		echo '<h1>Query - '.$e->data[1].'</h1>';
		echo '<h3>Failed - '.$e->data[0].'</h3>';
	});
	
	$db->connect();
	$db->query('SELECT * FROM example');
	$db->query('SELECT * FROM example2');
	$db->query('SELECT * FROM example3');
	$db->query('SELECT * FROM example4');
	
	$db->connect(); //Shows how unbind stops the connected event running again.
?>