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
else if (isset($_POST['submit']) || isset($_POST['keySubmit'])){
	$eid = $_POST['event'];
	$query = "SELECT * FROM events where id=$eid LIMIT 1;";
	$result = $db_connection->query($query);
	if (!$result){
		$transitionName="Oops!";
		$body="<h3>An error occured.</h3>";
	}
	else{
		$row = mysqli_fetch_array($result);
		if ($row[7] != null && (!isset($_POST['eidpass']) || empty($_POST['eidpass']))){
			$transitionName="Enter Private Event Key";
			$body .= <<< E
				<form id = 'eventkeyform' action = "{$_SERVER['PHP_SELF']}" method="post">
				<h3><strong>Event Title:</strong> {$row[1]}</h3>
				<h3><strong>Organization:</strong> {$row[2]}</h3>
				<input type='hidden' name='event' value={$eid}>
				<input type='text' required name="eidpass" id="eidpass" 
					style="margin-top: 10px;
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
	        	margin: 20px;" placeholder="Event Key">

	        	<div class="row">
				    <div class="form-group col-xs-6">
				        <button type="submit" id="submit" name="keySubmit" class="btn btn-success btn-lg"><span class="glyphicon glyphicon-lock"> </span> Submit Key </button>
				    </div>
				    <div class="form-group col-xs-6">
				        <button type="reset"  name="reset" class="btn btn-success btn-lg"><span class="glyphicon glyphicon-erase">&nbsp; </span> Reset</button>
				    </div>
				</div>

				</form>
E;
		}
		else if ($row[7] == null || password_verify($row[7], password_hash(trim($_POST['eidpass']), PASSWORD_DEFAULT))){
			$transitionName = "Enter Participant Information";
			$body .= <<< E
			<form id="joinform" action="join_event_process.php" method="post">
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
				$body .= '<input type="radio" style="margin-right: 1rem;" name="joinLocation" value="'.$row2[1].'"required/>'."".$row2[1].'<br><br>';
			}

			$body .= <<<EOBODY
			<p style="display:inline;">Arrival Time:</p>
			<input type='datetime-local' required id="arrivalTime" name="arrivalTime" style="margin-top: 10px;
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
					<button style="margin: 0 auto;" type="submit" id="submit" name="submitJoinLocation" class="btn btn-success btn-lg"><span class="glyphicon glyphicon-ok-circle"></span> Join Event </button>
				</div>
			</div>
EOBODY;
		}
		else{
			$transitionName="Oops!";
			$x = $_POST['eidpass'];
			$body="<h3>An error occured. $x $row[7]</h3>";
		}
	}
}
$page = generatePage($body, "Join an Event", $transitionName);
echo $page;
?>