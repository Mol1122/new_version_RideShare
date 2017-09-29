<?php
require_once("supportBody.php");
require_once("dbLogin.php");

session_start();
if ((!isset($_SESSION['username']) || empty($_SESSION['username']))){
    header('Location: ' . "../index.php", true, 303);
    exit();
}

$username = $_SESSION['username'];
?>


<!doctype html>

<html lang = "en">

<head>
	<title> RideShare </title>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Group Project for CMSC389N">
    <meta name="author" content="Stefani Moore">
    <!--icon-->
    
    <link rel="shortcut icon" href="https://cdn2.iconfinder.com/data/icons/circle-icons-1/64/car-128.png" type="image/vnd.microsoft.icon" />
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>
	
    <!-- Bootstrap Core CSS -->
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!--Theme CSS -->
    <link href="../css/styleMainPage.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Exo+2:200" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Bubbler+One|Exo+2:200" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Bubbler+One|Exo+2:200|Julius+Sans+One" rel="stylesheet">

    <!-- Link to externals -->
    <script type="text/javascript" src = "login_js.js"> </script>
    <link href="login_style.css" rel="stylesheet" type="text/css"/>

</head>

<body id="page-top" class="index" onload="document.getElementById('defaultOpen').click()">

	<!-- Navigation -->
    <nav id="mainNav" class="navbar navbar-default navbar-fixed-top navbar-custom">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span> Menu <i class="fa fa-bars"></i>
                </button>
                <a class="navbar-brand" href="#page-top">UMD RideShare</a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <a href="logout.php">Log Out</a>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container-fluid -->
    </nav>

	<div class="tab" align="center">
		<button class="tablinks" id='defaultOpen' onclick="openTab(event, 'newEvent')">Join New Event</button>
		<button class="tablinks" onclick="openTab(event, 'editEvent')">Edit/Leave My Events</button>
        <button class="tablinks" onclick="openTab(event, 'viewHistory')">View My Events</button>
        <hr id="slidebar">
	</div> 

    <br><br>
	<div class = "tabcontent" id="newEvent" align="center">
        <br>
        <form action="select_event.php">
            <div class="row control-group">
                <div class="form-group col-xs-12">
                    <button type="submit" name="create" class="btn btn-success btn-lg">Join New Event</button>
                </div>
            </div>
        </form>
	</div>
    <div class="tabcontent" id="editEvent" align="center">
 <?php 
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
    $query = "SELECT * FROM joinedEvents WHERE user_name=\"$user_name\" AND time > NOW() ORDER BY time DESC;";
    $result = $db->query($query, MYSQLI_STORE_RESULT);
    if (!$result){
        $transitionName = "Oops!";
        $body .= '<h3>Sorry, something went wrong. Try again later! </h3>';
    }
    else if ($result->num_rows === 0){
        $transitionName = "No Events Joined";
        $body .= '<h3>You have no active events.</h3>';
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

    </div>
    <div class="tabcontent" id="viewHistory" align="center">
        <?php 
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
        $transitionName = "My Events";
        $body .= '<h3>You have joined the following events.</h3>';
        while ($row = mysqli_fetch_array($result)){
            $query2 = "SELECT * FROM events WHERE id=$row[1] LIMIT 1;";
            $result2 = $db->query($query2, MYSQLI_STORE_RESULT);
            $row1 = mysqli_fetch_array($result2);
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
    }
}
$page = generatePage($body, "View My Events", $transitionName);
echo $page;
?>
    </div>
    <footer class="text-center footer" id="footer">
        <div class="footer-above">
            <div class="container">
                <div class="row">
                    <div class="footer-col col-md-4">
                        <h3>Location</h3>
                        <p>University of Maryland
                            <br>College Park, MD
                            <br>(301) 405-1000</p>
                    </div>
                    <div class="footer-col col-md-4">
                        <h3>Around the Web</h3>
                        <ul class="list-inline">
                            <li>
                                <a href="#" class="btn-social btn-outline"><span class="sr-only">Facebook</span><i class="fa fa-fw fa-facebook"></i></a>
                            </li>
                            <li>
                                <a href="#" class="btn-social btn-outline"><span class="sr-only">Google Plus</span><i class="fa fa-fw fa-google-plus"></i></a>
                            </li>
                            <li>
                                <a href="#" class="btn-social btn-outline"><span class="sr-only">Twitter</span><i class="fa fa-fw fa-twitter"></i></a>
                            </li>
                            <li>
                                <a href="#" class="btn-social btn-outline"><span class="sr-only">Linked In</span><i class="fa fa-fw fa-linkedin"></i></a>
                            </li>
                            <li>
                                <a href="#" class="btn-social btn-outline"><span class="sr-only">Dribble</span><i class="fa fa-fw fa-dribbble"></i></a>
                            </li>
                        </ul>
                    </div>
                    <div class="footer-col col-md-4">
                        <h3>About RideShare</h3>
                        <p>RideShare is a free to use application created for CMSC389N Spring 2017 at UMD.</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-below">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        Copyright &copy; Ride Share 2017
                    </div>
                </div>
            </div>
        </div>
    </footer>
<script>

  $(document).ready(function() {

   var docHeight = $(window).height();
   var footerHeight = $('#footer').height();
   var footerTop = $('#footer').position().top + footerHeight;

   if (footerTop < docHeight) {
    $('#footer').css('margin-top', 10+ (docHeight - footerTop) + 'px');
   }
  });
 </script>
</body>
</html>


