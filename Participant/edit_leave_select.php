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

$db = new mysqli($host, $user, $password, $database);
if ($db_connection->connect_error) {
    $transitionName .= "Sorry, our servers Down :(";
    $body .= "Connection to the database error<br />";
    die($db_connection->connect_error);
} 
else{
	$user_name = trim($_SESSION['username']);
	$query = "SELECT * FROM joinedEvents WHERE user_name=\"$user_name\" ORDER BY time DESC;";
	$result = $db->query($query, MYSQLI_STORE_RESULT);
	if (!$result){
		$transitionName = "Oops!";
		$body .= '<h3>Sorry, something went wrong. Try again later! </h3>';
	}
	else if ($result->num_rows === 0){
		$transitionName = "No Events Joined";
		$body .= '<h3>You have not joined any events.</h3>';
	}
	else{
		$transitionName = "Leave or Edit Event";
		$body .= "<form id=\"leaveeditform\" action = \"edit_leave_process.php\" method=\"post\">";
		$body .= '<h3>Select an event to leave or edit.</h3>';
		while ($row = mysqli_fetch_array($result)){
			$query2 = "SELECT * FROM events WHERE id=$row[1] LIMIT 1;";
			$result2 = $db->query($query2, MYSQLI_STORE_RESULT);
			$row1 = mysqli_fetch_array($result2);
			$body .= '<input type="radio" style="margin-right: 1rem;" name="radioLeaveEdit" value="'.$row1[0].'"required/>'."".$row1[1].'<br>';
			$body .= <<<EOBODY

					<div class="row control-group btn-outline" style="padding: 20px;text-align: left;color:black;border-radius: 10px; border:1px; border-color:black; background-color:rgba(0,0,0, .2);">
						<h3>Event information:</h3>
						<p><strong>Event Name: </strong> {$row1[1]}</p>
                        <p><strong>Event Location: </strong> {$row1[3]} </p>
                        <p><strong>My Pickup Location: </strong> {$row[2]}</p>
                        <p><strong>My Arrival Time: </strong> {$row[3]}</p>
                        <p><strong>Event Time: </strong> {$row1[4]} </p>
                        <p><strong>Website: </strong> {$row1[5]} </p><br>
EOBODY;
			if ($row1[7] != null){
				$body .= <<< EOBODY
					<p><strong>Event Key: </strong> {$row1[7]} </p><br>
EOBODY;
			}
			$body .= <<< EB
			<h4>Participation: {$row1[6]} </h4>
			</div><br><br>
EB;
		}
		$body .= <<< E
		    <div style="margin:20px;">
		        <button type="submit" id="submit" name="editEvent" class="btn btn-success btn-lg"><span class="glyphicon glyphicon-pencil">&nbsp;</span> Edit Event </button>
		    </div>
		    <div style="margin:20px;">
		        <button type="submit"  style = "border:#ff0000; background-color:#ff0000;" name="leaveEvent" class="btn btn-success btn-lg"><span class="glyphicon glyphicon-remove">&nbsp;</span> Leave Event</button>
		    </div>
		</form>
E;
	}
}
$page = generatePage($body, "Leave or Edit an Event", $transitionName);
echo $page;
?>