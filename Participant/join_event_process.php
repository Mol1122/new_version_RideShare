<?php 
require_once("support.php");
require_once("dbLogin.php");

session_start();
if (!isset($_SESSION['username']) || empty($_SESSION['username'])){
	header("Location: ../index.php");
	exit();
}

$transitionName="";
$body = "";

$db_connection = new mysqli($host, $user, $password, $database);
if ($db_connection->connect_error) {
    $transitionName .= "Sorry, our servers Down :(";
    $body .= "Connection to the database error<br />";
    die($db_connection->connect_error);
}
else if (isset($_POST['submitJoinLocation'])){
	$eid = $_POST['eid'];
	$user_name = $_SESSION['username'];
	$location = $_POST['joinLocation'];
	$time = $_POST['arrivalTime'];
	$query4 = "SELECT * FROM joinedEvents WHERE user_name=\"$user_name\" AND eid=$eid;";
	$result4 = $db_connection->query($query4);
	if ($result4->num_rows > 0){
		$transitionName = "Already Joined";
		$body = "<h3>You have already joined this event.</h3>";
	}
	else{
		$query = "INSERT into joinedEvents VALUES(\"$user_name\", $eid, \"$location\", \"$time\");";
		$result = $db_connection->query($query);
		$query2 = "UPDATE events SET participation=participation+1 WHERE id=$eid;";
		$result2 = $db_connection->query($query2);
		$query3 = "UPDATE eventLocations SET loc_participants=loc_participants+1 WHERE eid=$eid AND location=\"$location\";";
		$result3 = $db_connection->query($query3);
		if ($result && $result2 && $result3){
			$transitionName = "Joined Event Successfully!";
			$body = "<h3>Enjoy your event!</h3>";
		}
		else{
			$transitionName="Failed :(";
			$body = "<h3> Sorry, something went wrong. </h3>";
		}
	}
} 
$page = generatePage($body, "Join an Event", $transitionName);
echo $page;
?>
