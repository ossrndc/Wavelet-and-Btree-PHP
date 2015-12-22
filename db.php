<?php
	$dbhost = 'localhost';
	$dbuser = 'root';
	$dbpass = '';
	$dbname = 'mysearch';

	try {
		$conn = new PDO("mysql:host=$dbhost;dbname=mysearch", $dbuser, $dbpass);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}
	catch(PDOException $e) {
		echo "Connection Failed".$e->getMessage();
	}
?>