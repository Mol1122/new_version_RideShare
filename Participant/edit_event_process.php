<?php 
require_once("support.php");
require_once("dbLogin.php");

session_start();
if (!isset($_SESSION['username']) || empty($_SESSION['username'])){
	header("Location: ../index.php");
	exit();
}

$transitionName = "";
$body = "";

$db_connection = new mysqli($host, $user, $password, $database);
if ($db_connection->connect_error) {
    $transitionName .= "Sorry, our servers Down :(";
    $body .= "Connection to the database error<br />";
    die($db_connection->connect_error);
} 
else if (isset($_POST['submitEditLocation'])){
	$eid = $_POST['eid'];
	$user_name = $_SESSION['username'];
	$query = "SELECT * FROM joinedEvents WHERE eid = $eid AND user_name=\"$user_name\" LIMIT 1;";
	$result = $db_connection->query($query);
	$row = mysqli_fetch_array($result);
	$old_location = $row[2];
	$old_time = $row[3];
	$new_location = trim($_POST['joinLocation']);
	$new_time = trim($_POST['arrivalTime']);
	$query2 = "UPDATE eventLocations SET loc_participants = loc_participants-1 WHERE loc_participants > 0 AND eid = $eid AND location=\"$old_location\";";
	$result2 = $db_connection->query($query2);
	$query3 = "UPDATE eventLocations SET loc_participants = loc_participants+1 WHERE eid = $eid AND location=\"$new_location\";";
	$result3 = $db_connection->query($query3);
	$query4 = "UPDATE joinedEvents SET location=\"$new_location\" WHERE eid = $eid AND user_name=\"$user_name\";";
	$result4 = $db_connection->query($query4);
	$query4 = "UPDATE joinedEvents SET time=\"$new_time\" WHERE eid = $eid AND user_name=\"$user_name\";";
	$result4 = $db_connection->query($query4);
	if ($result && $result2 &&$result3 && $result4){
		$transitionName = "Edited Event Successfully!";
		$body = "<h3>Enjoy your event!</h3>";
	}
	else{
		$transitionName="Failed :(";
		$body = "<h3> Sorry, something went wrong.</h3>";
	}
}
else{
	$transitionName="Oops!";
	$body = "<h3>Something went wrong.</h3>";
}
$page = generatePage($body, "Leave or Edit Event", $transitionName);
echo $page;
?>