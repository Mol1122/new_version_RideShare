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
?>

<html lang="en">

<head >
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">


    <style>
        .controls {
            margin-top: 10px;
            border: 1px solid transparent;
            border-radius: 2px 0 0 2px;
            box-sizing: border-box;
            -moz-box-sizing: border-box;
            height: 32px;
            outline: none;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
            margin-bottom: 15px;
            width: 300px;
        }
        .filterer {
        	display:inline-block;
        	text-align: center;
        	margin: 20px;
        }
        #nameFilter, #locationFilter, #timeAfterFilter, #timeBeforeFilter {
        	text-align: left;
            font-weight: bold;
            color: #303030;
            text-overflow: ellipsis;
        }

        ::-webkit-datetime-edit { color: #777777;}

    </style>


    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Ride share research project">
    <meta name="author" content="Xi Chen">
    <title>New Event</title>
    <style>
        #target {
            width: 345px;
        }
    </style>

</head>
<!--icon-->

<link rel="shortcut icon" href="https://cdn2.iconfinder.com/data/icons/circle-icons-1/64/car-128.png" type="image/vnd.microsoft.icon" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<!-- Bootstrap Core CSS -->
<link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

<!--<!-- Theme CSS -->
<link href="../css/styleMainPage.css" rel="stylesheet">

<!-- Custom Fonts -->
<link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
<link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
<link href="https://fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic" rel="stylesheet" type="text/css">
<link href="https://fonts.googleapis.com/css?family=Exo+2:200" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Bubbler+One|Exo+2:200" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Bubbler+One|Exo+2:200|Julius+Sans+One" rel="stylesheet">
</head>

<body id="page-top" class="index" onload="set();">

<div class="page-scroll">
    <a href="#portfolioModal1" id="sign" style=" display: none;" class="portfolio-link" data-toggle="modal"><span class="glyphicon glyphicon-user"></span> Sign Up</a>
</div>


<div class="container">
    <div class="row justify-content-md-center">
        <br><br></br>
        <h1 align="center"> Select An Event To Join</h1><br>
        <hr class="star-primary">
    </div>
</div>

<div class="container" align="center" style="width: 80%;">
    <form id = 'filterform' action = "<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
	<h3 align="center">Filter Events By .  .  .   </h3>
	<div class="filterer" id="Name">
		<input type='checkbox' style = "margin-right: 5px;" id='nameFilter' name="filterByName" value="Yes" onchange = "toggleInput(this);"/> <h4 style="display: inline-block;"> Event Name </h4> <br>
		<input type='text' name="nameFilterText" id="nameFilterText" class = "controls" placeholder="Event Name" readonly>
	</div>

	<div class="filterer" id="Location">
		<input type='checkbox' style = "margin-right: 5px;" id='locationFilter' name="filterByLocation" value="Yes" onchange = "toggleInput(this);"/> <h4 style="display: inline-block;"> Event Location </h4> <br>
		<input type='text' id="locationFilterText" name="locationFilterText" class = "autocomplete controls" placeholder="Event Location" readonly>
	</div>

	<div class="filterer" id="TimeAfter">
		<input type='checkbox' style = "margin-right: 5px;" id='timeAfterFilter' name="filterByTimeAfter" value="Yes" onchange = "toggleInput(this);"/> <h4 style="display: inline-block;"> Events Occuring After Time </h4> <br>
		<input type='datetime-local' id="timeAfterFilterText" name="timeAfterFilterText" class = "controls" readonly>
	</div>

	<div class="filterer" id="TimeBefore">
		<input type='checkbox' style = "margin-right: 5px;" id='timeBeforeFilter' name="filterByTimeBefore" value="Yes" onchange = "toggleInput(this);"/> <h4 style="display: inline-block;"> Events Occuring Before Time </h4> <br>
		<input type='datetime-local' id="timeBeforeFilterText" name="timeBeforeFilterText" class = "controls" readonly>
	</div>

	<div class="filterer" id="Website">
		<input type='checkbox' style = "margin-right: 5px;" id='websiteFilter' name="filterByWebsite" value="Yes" onchange = "toggleInput(this);"/> <h4 style="display: inline-block;"> Event Website </h4> <br>
		<input type='text' id="websiteFilterText" name="websiteFilterText" class = "controls" placeholder = "Event Website" readonly>
	</div>

	<div class="filterer" id="Key">
		<input type='checkbox' style = "margin-right: 5px;" id='keyFilter' name="filterByKey" value="Yes" onchange = "toggleInput(this);"/> <h4 style="display: inline-block;"> Event Key (Private Events Only) </h4> <br>
		<input type='text' id="keyFilterText" name="keyFilterText" class = "controls" placeholder = "Event Key" readonly>
	</div>

<div class="row">
    <div class="form-group col-xs-6">
        <button type="submit" id="submit" name="filterSubmit" class="btn btn-success btn-lg"><span class="glyphicon glyphicon-search"> </span> Find Events </button>
    </div>
    <div class="form-group col-xs-6">
        <button type="reset"  name="reset" class="btn btn-success btn-lg"><span class="glyphicon glyphicon-erase">&nbsp; </span> Reset</button>
    </div>
</div>

</form>

<?php
if (isset($_POST['filterSubmit']) || 1===1){
	$query = "SELECT * FROM events WHERE time > NOW()";
	if (isset($_POST['filterByName']) && $_POST['filterByName'] == "Yes"){
		$text = trim($_POST['nameFilterText']);
		$query .= " AND title LIKE \"%$text%\"";
	}
	if (isset($_POST['filterByLocation']) && $_POST['filterByLocation'] == "Yes"){
		$text = trim($_POST['locationFilterText']);
		$query .= " AND location=\"$text\"";
	}
	if (isset($_POST['filterByTimeAfter']) && $_POST['filterByTimeAfter'] == "Yes"){
		$text = trim($_POST['timeAfterFilterText']);
		$query .= " AND time >= \"$text\"";
	}
	if (isset($_POST['filterByTimeBefore']) && $_POST['filterByTimeBefore'] == "Yes"){
		$text = trim($_POST['timeBeforeFilterText']);
		$query .= " AND time <= \"$text\"";
	}
	if (isset($_POST['filterByWebsite']) && $_POST['filterByWebsite'] == "Yes"){
		$text = trim($_POST['websiteFilterText']);
		$query .= " AND website LIKE \"%$text%\"";
	}
	if (isset($_POST['filterByKey']) && $_POST['filterByKey'] == "Yes"){
		$text = trim($_POST['keyFilterText']);
		$query .= " AND password=\"$text\"";
	}
	$query .= ";";
	$result = $db_connection->query($query);
	if (!$result){
		echo "<h3>Search failed.</h3>";
	}
	else if ($result->num_rows === 0) {
		echo "<h3>No matching events.</h3>";
	}
	else{
		$extra = '<h3>Select an event to join. </h3>';
		$extra .= '<form id = \'joinform\' action=\'join_event.php\' method=\'post\'>';
		while ($row1 = mysqli_fetch_array($result)){
			$query2 = "SELECT * from eventLocations where eid=$row1[0];";
			$result2 = $db_connection->query($query2, MYSQLI_STORE_RESULT);
			$extra .= '<input type="radio" style="margin-right: 1rem;" name="event" value="'.$row1[0].'"required/>'."".$row1[1].'<br>';
			$extra .= <<<EOBODY

					<div class="row control-group btn-outline" style="padding: 20px;text-align: left;color:black;border-radius: 10px; border:1px; border-color:black; background-color:rgba(0,0,0, .2);">
						<h3>Event information:</h3>
						<h3><strong>Organization: </strong> {$row1[2]}</h3>
						<p><strong>Event Name: </strong> {$row1[1]}</p>
EOBODY;
			if ($row1[7] == null){
				$extra .= "<p><strong>Event Location: </strong> $row1[3] </p>";
				$ct = 0;
				while ($row2 = mysqli_fetch_array($result2)){
					$ct += 1;
					$extra .= <<< EOBODY
					<p><strong>Pickup Location #{$ct}: </strong> {$row2[1]}</p>
EOBODY;
				}
				$extra .= <<< EOBODY
                        <p><strong>Time: </strong> {$row1[4]} </p>
                        <p><strong>Website: </strong> {$row1[5]} </p><br>
                        <h4>Participation: {$row1[6]} </h4>
						</div><br><br>				
EOBODY;
			}
			else{
				$extra .= "<p><span style=\"margin: 5px;\" class=\"glyphicon glyphicon-lock\"></span><strong>This event is a private event.</strong><p></div><br><br>";
			}
                        
			
		}
		$extra .= <<<EOBODY
			<div class = "row" align="center">
				<div class="form-group">
					<button style="margin: 0 auto;" type="submit" id="submit" name="submit" class="btn btn-success btn-lg"><span class="glyphicon glyphicon-ok-circle"></span> Join Event </button>
				</div>
			</div>
EOBODY;
		$extra .= '</form>';
		echo $extra;
	}
}
?>

<div align="center" style = "margin: 20px;">
        <button type="button" style = "margin: 0 auto;"id="closeB" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
</div>

<!-- Bootstrap Core JavaScript -->
<script src="../vendor/bootstrap/js/bootstrap.min.js"></script>

<!-- Plugin JavaScript -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>

<!-- Contact Form JavaScript -->
<script src="../js/jqBootstrapValidation.js"></script>

<!-- Theme JavaScript -->
<script src="../js/freelancer.min.js"></script>

<script>
    function set(){
        console.log("in");
    }

    $("#closeX").click(function () {
        window.location.replace("../index.php");
    });

    $("#closeB").click(function () {
        window.location.replace("../index.php");
    });
</script>

<script>
	function toggleInput(element){
		if (element.checked){
			document.getElementById(element.id+"Text").readOnly = false;
			document.getElementById(element.id+"Text").required = true;
		}
		else{
			document.getElementById(element.id+"Text").readOnly = true;
			document.getElementById(element.id+"Text").required = false;
			document.getElementById(element.id+"Text").value = '';
		}
	}
</script>
<script type="text/javascript">
	window.onload = function(){
	function initialize() {

	    var acInputs = document.getElementsByClassName("autocomplete");

	    for (var i = 0; i < acInputs.length; i++) {

	        var autocomplete = new google.maps.places.Autocomplete(acInputs[i]);

	        google.maps.event.addListener(autocomplete, 'place_changed', function () {
	        });
	    }
	}

	initialize();  
	}

</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCC4rck9rZxndKVt85FYnunfSnW00SCoco&libraries=places"
    async defer></script>

</body>
</html>


