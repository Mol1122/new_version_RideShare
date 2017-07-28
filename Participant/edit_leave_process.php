<?php 
require_once("support.php");
require_once("dbLogin.php");

session_start();
if (!isset($_SESSION['username']) || empty($_SESSION['username'])){
	header("Location: ../index.html");
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
else if (isset($_POST['leaveEvent'])){
	$eid = $_POST['radioLeaveEdit'];
	$user_name = $_SESSION['username'];
	$query = "SELECT * FROM joinedEvents WHERE user_name=\"$user_name\" AND eid=$eid LIMIT 1;";
	$result = $db_connection->query($query);
	$row = mysqli_fetch_array($result);
	$location = $row[2];
	$query2 = "DELETE FROM joinedEvents WHERE user_name=\"$user_name\" AND eid=$eid;";
	$result2 = $db_connection->query($query2);
	$query3 = "UPDATE events SET participation=participation-1 WHERE participation>0 AND id=$eid;";
	$result3 = $db_connection->query($query3);
	$query4 = "UPDATE eventLocations SET loc_participants=loc_participants-1 WHERE loc_participants>0 AND eid=$eid and location=\"$location\";";
	$result4 = $db_connection->query($query4);
	if ($result && $result2 &&$result3 &&$result4){
		$transitionName = "Left Event Successfully!";
		$body = "<h3>Sorry you couldn't make it :(</h3>";
	}
	else{
		$transitionName="Failed :(";
		$body = "<h3> Sorry, something went wrong.</h3>";
	}
}
else if (isset($_POST['editEvent'])){
	$eid = $_POST['radioLeaveEdit'];
	$query = "SELECT * FROM events WHERE id=$eid LIMIT 1;";
	$result = $db_connection->query($query);
	$row = mysqli_fetch_array($result);
	$user_name = $_SESSION['username'];
	$query3 = "SELECT * FROM joinedEvents WHERE eid=$eid AND user_name=\"$user_name\" LIMIT 1;";
	$result3 = $db_connection->query($query3);
	$row3 = mysqli_fetch_array($result3);
	$old_location = $row3[2];
	$old_time = $row3[3];
	$old_time = str_replace(" ", "T", $old_time);
	$transitionName = "Enter Participant Information";
			$body .= <<< E
			<form id="joinform" action="edit_event_process.php" method="post">
				<input type="hidden" name="eid" value={$eid}>
				<h3><strong>Event Title:</strong> {$row[1]}</h3>
				<h3><strong>Organization:</strong> {$row[2]}</h3>
				<h3><strong>Event Location:</strong> {$row[3]}</h3>
				<h3><strong>Event Time:</strong> {$row[4]}</h3>
				<h3><strong>Event Website:</strong> {$row[5]}</h3>
E;
			if ($row[7] != null){$body.="<h3><strong>Event Key:</strong> {$row[7]}</h3>";}
			$body .= "<br><br><h2>Pick Me Up At: </h2><br>";
			$query2= "SELECT * FROM eventLocations WHERE eid=$eid;";
			$result2 = $db_connection->query($query2);
			while ($row2 = mysqli_fetch_array($result2)){
				if ($row2[1] == $old_location){
					$body .= '<input type="radio" style="margin-right: 1rem;" name="joinLocation" value="'.$row2[1].'"required checked/>'."".$row2[1].'<br><br>';
				}
				else{
					$body .= '<input type="radio" style="margin-right: 1rem;" name="joinLocation" value="'.$row2[1].'"required/>'."".$row2[1].'<br><br>';
				}
			}

			$body .= <<<EOBODY
			<p style="display:inline;">Arrival Time:</p>
			<input type='datetime-local' required id="arrivalTime" name="arrivalTime" value="{$old_time}" style="margin-top: 10px;
	            border: 1px solid transparent;
	            border-radius: 2px 0 0 2px;
	            box-sizing: border-box;
	            -moz-box-sizing: border-box;
	            height: 32px;
	            outline: none;
	            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
	            margin-bottom: 80px;
	            width: 300px;
	            display:inline-block;
	        	text-align: center;
	        	margin: 20px;><br><br>

			<div class = "row" align="center">
				<div class="form-group">
					<button style="margin: 0 auto;" type="submit" id="submit" name="submitEditLocation" class="btn btn-success btn-lg"><span class="glyphicon glyphicon-pencil"></span> Submit Changes </button>
				</div>
			</div>
			</form>
EOBODY;
}
else{
	$transitionName="Oops!";
	$body = "<h3>Something went wrong.</h3>";
}
$page = generatePage($body, "Leave or Edit Event", $transitionName);
echo $page;
?>