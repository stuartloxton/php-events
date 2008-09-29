<pre>
<?php
	include('index.php');

	class database extends EventHandler {
		
		function connect() {
			// Do connection code
			$this->connected();
		}
		
		function query() {
			// make code;
			$success = true;
			if($success) {
				$this->querySuccess(array('test', 'woop', 'success'));
			} else {
				$this->queryError();
			}
		}
		
	}
	
	$db = new database;
	
	$db->connected(function() {
		define('DB_CONNECTED', 'true');
		echo '<h1>Connected</h1>';
		return Event::unbind();
	});
	$db->querySuccess(function($e) {
		echo '<h1>Query Returned</h1><pre>';
		return Event::stop();
		echo '</pre>';
	});
	$db->queryError(function() {
		header('Location: /error/oops/');
		exit;
	});
	$db->connected();
	$db->query();
	$db->connected();
?>
</pre>