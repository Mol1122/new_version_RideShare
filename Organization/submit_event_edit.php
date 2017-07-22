<?php
session_start();
if (!isset($_SESSION['organization']) || empty($_SESSION['organization'])){
    header("Location: ../index.html");
    exit();
}

require_once("support.php");
require_once("dbLogin.php");

$transitionName = "";
$body = "";

if (isset($_POST["submit"])){
	$db_connection = new mysqli($host, $user, $password, $database);
    if ($db_connection->connect_error) {
        $transitionName .= "Sorry, our servers Down :(";
        $body .= "Connection to the database error<br />";
        die($db_connection->connect_error);
    } 
    else{
    	$transitionName = "Edit";
        $eid = $_POST['eid'];
        $query = "SELECT * FROM events WHERE id=\"$eid\" LIMIT 1;";
        $result = $db_connection->query($query, MYSQLI_STORE_RESULT);
        if (!$result || $result->num_rows === 0){
            $transitionName="Oops!";
            $body .= "<h3>Sorry, an error occured. Try again later! </h3>";
        }
        else{
            $row = mysqli_fetch_array($result);
            $old_event_title = $row[1];
            $old_location = $row[3];
            $old_time = $row[4];
            $old_time = str_replace(" ", "T", $old_time);
            $old_website = $row[5];
            $event_title = trim($_POST["event_title"]);
	        $organization = $_SESSION['organization'];
	        $location = trim($_POST["dep"]);
	        $time = trim($_POST["time"]);
	        $website = trim($_POST["website"]);
	        $query = "UPDATE events SET title=\"$event_title\", location=\"$location\", time=\"$time\", website=\"$website\" WHERE id=$eid;";
	        $result = $db_connection->query($query);
	        if (!$result) {
	            $transitionName .= "Edit Event Fail";
	            die("Edit failed: " . $db_connection->error);
	        } 
	        else {
	            $transitionName = "Update Success";
	            $body="<h3>The event has been updated!</h3><br><br>";
        	}
        }
    }
}

$page=generatePage($body, $transitionName);
echo $page;
?>