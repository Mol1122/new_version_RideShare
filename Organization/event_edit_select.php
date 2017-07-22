<?php

require_once("support.php");
require_once("dbLogin.php");

session_start();
if (!isset($_SESSION['organization']) || empty($_SESSION['organization'])){
	header("Location: ../index.html");
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
else{
	$organization = trim($_SESSION["organization"]);
	$query = "SELECT * from events where organization = \"$organization\" and time > NOW();";
	$result = $db_connection->query($query, MYSQLI_STORE_RESULT);

	if (!$result){
		$transitionName = "Oops!";
		$body .= '<h3>Sorry, something went wrong. Try again later! </h3>';
	}
	else if ($result->num_rows === 0){
		$transitionName = "No Events Active";
		$body .= '<h3>You have no active events to edit.</h3>';
	}
	else{
		$transitionName = "Edit an Event";
		$body .= '<h3>Select an event to edit. </h3>';
		$body .= '<form id = \'editform\' action=\'edit_event.php\' method=\'post\'>';
		while ($row1 = mysqli_fetch_array($result)){
			$body .= '<input type="radio" style="margin-right: 1rem;" name="event" value="'.$row1[0].'"required/>'."".$row1[1].'<br>';
			$body .= <<<EOBODY

					<div class="row control-group btn-outline" style="padding: 20px;text-align: left;color:black;border-radius: 10px; border:1px; border-color:black; background-color:rgba(0,0,0, .2);">
						<h3>Event information:</h3>
						<p><strong>Event Name: </strong> {$row1[1]}</p>
                        <p><strong>Location: </strong> {$row1[3]} </p>
                        <p><strong>Time: </strong> {$row1[4]} </p>
                        <p><strong>Website: </strong> {$row1[5]} </p><br>
						<h4>Participation: {$row1[6]}</h4>
					</div><br><br>
EOBODY;

		}
		$body .= <<<EOBODY
			<div class = "row" align="center">
				<div class="form-group">
					<button style="margin: 0 auto;" type="submit" id="submit" name="submit" class="btn btn-success btn-lg"><span class="glyphicon glyphicon-pencil"></span> Edit Event </button>
				</div>
			</div>
EOBODY;
		$body .= '</form>';
	}
}

$page = generatePage($body, "Edit an Event", $transitionName);
echo $page;
?>
