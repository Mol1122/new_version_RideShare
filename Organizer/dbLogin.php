<?php
	/* Update based on your database and account info */
	$host = "localhost";
	$user = "root";
	$password = null;
	$database = "rideshare";
	$table = "users";
	$tableDrivers = "drivers";
	$tableRiders = "riders";
	function connectToDB($host, $user, $password, $database) {
	$db = mysqli_connect($host, $user, $password, $database);
	if (mysqli_connect_errno()) {
		echo "Connect failed.\n".mysqli_connect_error();
		exit();
	}
	return $db;
}
?>